<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes, LogsActivity, FullTextSearch;

    protected $fillable = [
        'name', 'email', 'password', 'profile_id', 'state',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $searchable = [
        'name', 'email'
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function incomes()
    {
        return $this->hasMany(Income::class);
    }

    public function small_boxes()
    {
        return $this->hasMany(SmallBox::class);
    }

    public static function listUsers()
    {
        return static::orderBy('name')->select('id', 'name')->where('state', 1)->get();
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
}
