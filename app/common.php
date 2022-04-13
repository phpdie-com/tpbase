<?php
// 应用公共文件

if (!function_exists('blank')) {
    /**
     * Determine if the given value is "blank".
     *
     * @param mixed $value
     * @return bool
     */
    function blank($value)
    {
        if (is_null($value)) {
            return true;
        }

        if (is_string($value)) {
            return trim($value) === '';
        }

        if (is_numeric($value) || is_bool($value)) {
            return false;
        }

        if ($value instanceof Countable) {
            return count($value) === 0;
        }

        return empty($value);
    }
}

if (!function_exists('success_json')) {
    /** 成功信息返回
     * @param array $arr
     * @return \think\response\Json
     */
    function success_json(array $arr = []): \think\response\Json
    {
        $default = [
            'code' => 1,
            'message' => 'success',
            'data' => [],
        ];
        return json(array_merge($default, $arr));
    }
}

if (!function_exists('error_json')) {
    /** 失败信息返回
     * @param array $arr
     * @return \think\response\Json
     */
    function error_json(array $arr = []): \think\response\Json
    {
        $default = [
            'code' => 0,
            'message' => 'fail',
            'data' => [],
        ];
        return json(array_merge($default, $arr));
    }
}