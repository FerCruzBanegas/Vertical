<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Person extends ApiModel
{
    use SoftDeletes, LogsActivity, FullTextSearch;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'surnames', 'phone', 'address'
    ];
}
