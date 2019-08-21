<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Box extends ApiModel
{
    use SoftDeletes, LogsActivity, FullTextSearch;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'date_init', 'date_end', 'note', 'user_id',
    ];

    protected $searchable = [
        'title',
    ];

    public function accounts()
    {
        return $this->belongsToMany(Account::class);
    }
}
