<?php

namespace Laravel;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class posts extends Model{
    //laravelでは必要
    // const CREATED_AT = null;
    // const UPDATED_AT = null;
    // public $timestamps = false;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    //primaryKeyがidの場合は指定しなくても良い
    // protected $primaryKey = '(プライマリキー名)'
    protected $table = 'posts';

    //option
    protected $fillable = [
        'acknowledge',
        'permission',
        'label_text',
        'main_file',
        'menulevel_radio',
        'parentmenuid_check',
        'detail_richtext',
        'created_at',
        'updated_at',
    ];
}
