<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $hidden = [
        'deleted_at', 'created_at', 'updated_at'
    ];
    public $timestamps = true;
    protected $guarded = [];

    public static function createEx($data)
    {
        $result_res = [
            'isSuccess' => true,
            'error_message' => null,
            'model' => null
        ];

        $model = new static();
        $model->fill($data);
        $result = $model->save();

        if (!$result) {
            $result_res['error_message'] = 'save data error';
        }

        $result_res['isSuccess'] = $result;
        $result_res['model'] = $model;

        return $result_res;
    }

    public static function createMultiEx($data)
    {
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['created_at'] = Carbon::now();
            $data[$i]['updated_at'] = Carbon::now();
        }
        $result_res = [
            'isSuccess' => true,
            'error_message' => null,
            'model' => null
        ];

        $model = new static();
        $result = $model->insert($data);

        $result_res['isSuccess'] = $result;
        $result_res['model'] = $model;

        return $result_res;
    }

    public static function updateEx($filter, $data)
    {
        $result_res = [
            'isSuccess' => true,
            'error_message' => null,
            'model' => null
        ];

        $model = self::where($filter)->first();
        if (!$model) {
            $result_res['isSuccess'] = false;
            $result_res['error_message'] = 'Data not found';
        } else {
            $model->fill($data);
            $result = $model->save();

            $result_res['isSuccess'] = $result;
            $result_res['model'] = $model;
        }

        return $result_res;
    }
    public static function deleteEx($filter)
    {
        $result_res = [
            'isSuccess' => true,
            'error_message' => null,
            'model' => null
        ];

        $model = self::where($filter)->first();
        if (!$model) {
            $result_res['isSuccess'] = false;
            $result_res['error_message'] = 'Data not found';
        } else {
            $result = $model->delete();
            $result_res['isSuccess'] = $result;
            $result_res['model'] = $model;
        }

        return $result_res;
    }
}
