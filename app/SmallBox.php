<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class SmallBox extends ApiModel
{
    use LogsActivity;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'date_init', 'date_end', 'start_amount', 'used_amount', 'remaining_amount', 'actual_amount', 'account_id', 'user_id', 'state', 'note'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function amounts()
    {
        return $this->hasMany(Amount::class);
    }

    public function boxes()
    {
        return $this->belongsToMany(Box::class);
    }

    public static function getState($id)
    {
        return static::where('user_id', $id)->orderBy('id', 'desc')->take(1)->first();
    }
}
