<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Account extends ApiModel
{
    use SoftDeletes, LogsActivity, FullTextSearch, CascadeSoftDeletes;

    protected $cascadeDeletes = ['expenses', 'incomes'];

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title', 'date', 'number', 'amount', 'note', 'state',
    ];

    protected $searchable = [
        'title',
    ];

    public function incomes()
    {
        return $this->hasMany(Income::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function boxes()
    {
        return $this->belongsToMany(Box::class);
    }

    public static function listAccounts()
    {
        return static::orderBy('id', 'DESC')->select('id', 'title');
    }
}
