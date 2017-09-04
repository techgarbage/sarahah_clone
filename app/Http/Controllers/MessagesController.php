<?php

namespace App\Http\Controllers;

use App\Lib\ResultCode;
use App\Lib\Utils;
use App\Lib\ValidateRules;
use App\Models\Messages;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function send(Request $request)
    {
        $rules = [];
        $rules = ValidateRules::addRule($rules, 'messages.user_id', true);
        $rules = ValidateRules::addRule($rules, 'messages.content', true);
        $rules = ValidateRules::addRule($rules, 'messages.favorited', false);
        $validator = ValidateRules::validateParams($request->all(), $rules);
        if (!$validator['isValid']) {
            return Utils::resultForResponse(ResultCode::ERROR, null, $validator['Response']);
        }

        $result = Messages::createEx($request->all());
        if (!$result['isSuccess']) {
            return Utils::resultForResponse(ResultCode::ERROR, null, $result['error_message']);
        }

        return Utils::resultForResponse(ResultCode::SUCCESS, $result['model']);
    }

    public function index(Request $request)
    {
        $rules = [];
        $rules = ValidateRules::addRule($rules, 'messages.user_id', true);
        $validator = ValidateRules::validateParams($request->all(), $rules);
        if (!$validator['isValid']) {
            return Utils::resultForResponse(ResultCode::ERROR, null, $validator['Response']);
        }

        $messages = Messages::where('user_id', $request->input('user_id'))->get();
        return Utils::resultForResponse(ResultCode::SUCCESS, $messages->makeVisible('created_at'));
    }
}
