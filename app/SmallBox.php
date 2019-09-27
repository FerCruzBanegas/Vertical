<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class SmallBox extends ApiModel
{
    use SoftDeletes, LogsActivity;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'date_init', 'date_end', 'start_amount', 'used_amount', 'remaining_amount', 'actual_amount', 'user_id', 'state', 'note'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
