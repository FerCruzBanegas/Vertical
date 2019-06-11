<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IncomeType extends ApiModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'description',
    ];

    public function incomes()
    {
        return $this->hasMany(Income::class);
    }

    public static function listIncomeTypes()
    {
        return static::orderBy('id', 'DESC')->select('id', 'name')->get();
    }
}
