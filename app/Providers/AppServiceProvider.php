<?php

namespace Laravel\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * アプリケーションサービスの初期処理
     *
     * @return void
     */
    public function boot()
    {
        // カスタムバリデート
        Validator::extend('foo', function ($attribute, $value, $parameters, $validator) {
            return $value == 'foo';
        });

        // 電話番号
        Validator::extend('japan_tel', function($attribute, $value, $parameters)
        {
            if (preg_match("/^[0-9]{2,4}-[0-9]{2,4}-[0-9]{3,4}$/", $value) ||
                preg_match("/^[0-9]{2,4}[0-9]{2,4}[0-9]{3,4}$/", $value)) {
                return true;
            }
        });

        // 郵便番号
        Validator::extend('zip', function($attribute, $value, $parameters)
        {
            $zip = mb_convert_kana($value,'a','utf-8');
            if (preg_match("/^d{3}-d{4}$/",$zip)) {
                return true;
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
