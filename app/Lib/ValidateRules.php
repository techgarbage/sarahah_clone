<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 7/20/17
 * Time: 2:22 PM
 */

namespace App\Lib;

use Validator;
use Exception;
use App\Lib\ResultCode;

class ValidateRules
{
    private static $std_rules = [

        // users table
        'users' => [
            'name' => ['string', 'min:2'],
            'email' => ['email'],
            'password' => ['string', 'min:6', 'max:20']
        ],

        'common' => [
            'email' => ['email', 'unique:users'],
            'password' => ['string', 'min:6', 'max:20', 'confirmed']
        ]
    ];

    /**
     * @param $orgConstraint
     * @param $addRuleOrPath
     * @param bool $presence
     * @param bool $uploadMulti
     * @return mixed
     * @throws Exception
     */
    public static function addRule($orgConstraint, $addRuleOrPath, $presence = false, $uploadMulti = false)
    {
        if(gettype($addRuleOrPath) != 'string' ){
            throw new Exception('Type of variable "addRuleOrPath is not valid');
        }

        if ($uploadMulti == false) {
            $pieces = explode(".", $addRuleOrPath);
        } else {
            $pieces = explode("|", $addRuleOrPath);
        }
        $table_or_cateory_name = $pieces[0];
        $field = $pieces[1];
        // Add rule require
        $addRuleVal =  self::$std_rules[$table_or_cateory_name][$field];
        if ($presence) {
            array_push($addRuleVal, 'required');
        }

        // Assign rule
        $orgConstraint[$field] = $addRuleVal;

        return $orgConstraint;
    }

    public static function validateParams($params, $rules)
    {
        $result_valid = ['isValid' => true, 'Response' => null];
        $validator = Validator::make($params, $rules);

        if ($validator->fails()) {
            $errors = $validator->errors();
            $result_valid['isValid'] = false;
            $result_valid['Response'] = $errors;
        }

        return $result_valid;
    }
}