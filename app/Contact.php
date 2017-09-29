<?php

namespace Laravel;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class contact extends Model{
    //laravelでは必要
    // const CREATED_AT = null;
    // const UPDATED_AT = null;
    // public $timestamps = false;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    //primaryKeyがidの場合は指定しなくても良い
    // protected $primaryKey = '(プライマリキー名)'
    protected $table = 'contact';

    //option
    protected $fillable = [
        'name',
        'email',
        'tel',
        'zip',
        'prefecture',
        'address',
        'age',
        'hobby',
        'upfile',
        'message',
        'created_at',
        'updated_at',
    ];
}
