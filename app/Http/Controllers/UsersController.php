<?php

namespace App\Http\Controllers;

use App\Lib\ResultCode;
use App\Lib\Utils;
use App\Lib\ValidateRules;
use App\Models\Users;
use Illuminate\Http\Request;
use Auth;

class UsersController extends Controller
{
    public function register(Request $request)
    {
        $rules = [];
        $rules = ValidateRules::addRule($rules, 'users.name', true);
        $rules = ValidateRules::addRule($rules, 'common.email', true);
        $rules = ValidateRules::addRule($rules, 'common.password', true);
        $validator = ValidateRules::validateParams($request->all(), $rules);
        if (!$validator['isValid']) {
            return Utils::resultForResponse(ResultCode::ERROR, null, $validator['Response']);
        }

        $userData = [];
        $userData = Utils::hasKeyAssign($request, 'name', $userData);
        $userData = Utils::hasKeyAssign($request, 'email', $userData);
        $userData = Utils::hasKeyAssign($request, 'password', $userData);
        $result = Users::createEx($userData);
        if (!$result['isSuccess']) {
            return Utils::resultForResponse(ResultCode::ERROR, null, 'save data error');
        }

        return Utils::resultForResponse(ResultCode::SUCCESS, $result['model']);
    }

    public function login(Request $request)
    {
        $rules = [];
        $rules = ValidateRules::addRule($rules, 'users.email', true);
        $rules = ValidateRules::addRule($rules,'users.password', false);
        $validator = ValidateRules::validateParams($request->all(), $rules);
        if (!$validator['isValid']) {
            return Utils::resultForResponse(ResultCode::ERROR, null, $validator['Response']);
        }

        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];
        if (!Auth::attempt($credentials)) {
            return Utils::resultForResponse(ResultCode::ERROR, null, 'wrong account');
        }

        return Utils::resultForResponse(ResultCode::SUCCESS, Auth::user());
    }

}
