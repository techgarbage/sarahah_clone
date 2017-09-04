<?php

namespace App\Http\Controllers;

use App\Lib\ResultCode;
use App\Lib\Utils;
use App\Lib\ValidateRules;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

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
        try {
            $token = JWTAuth::attempt($credentials, [
                'exp' => Carbon::now()->addWeek()->timestamp,
            ]);

            if (!$token) {
                return Utils::resultForResponse(ResultCode::ERROR, null, 'Could not authenticate');
            } else {
                $data = [];
                $meta = [];
                $data['name'] = $request->user()->name;
                $meta['token'] = $token;
                return Utils::resultForResponse(ResultCode::SUCCESS, ['data' => $data, 'meta' => $meta]);
            }
        } catch (JWTException $e) {
            return Utils::resultForResponse(ResultCode::ERROR, null, 'Could not authenticate');
        }
    }

    public function detail(Request $request)
    {
        $rules = [];
        $rules = ValidateRules::addRule($rules, 'users.id', true);
        $validator = ValidateRules::validateParams($request->all(), $rules);
        if (!$validator['isValid']) {
            return Utils::resultForResponse(ResultCode::ERROR, null, $validator['Response']);
        }

        $user = Users::where('id', $request->input('id'))->get();
        if ($user->isEmpty()) {
            return Utils::resultForResponse(ResultCode::ERROR, null, 'not found');
        }

        return Utils::resultForResponse(ResultCode::SUCCESS, $user[0]);
    }
}
