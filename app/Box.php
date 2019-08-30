<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Box extends ApiModel
{
    use SoftDeletes, LogsActivity;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'date_init', 'date_end', 'amount', 'note'
    ];

    public function accounts()
    {
        return $this->belongsToMany(Account::class)->withPivot('income', 'expense', 'cash')->withTimestamps();
    }
}
