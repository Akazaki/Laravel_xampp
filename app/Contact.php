<?php

namespace Laravel;

use IlluminateDatabaseEloquentModel;

class Contact extends Model
{
    protected $fillable = [
        'name',
        'email',
        'message',
    ];
}