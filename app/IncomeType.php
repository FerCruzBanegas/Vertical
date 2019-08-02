<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class IncomeType extends ApiModel
{
    use SoftDeletes, LogsActivity, FullTextSearch, CascadeSoftDeletes;

    protected $cascadeDeletes = ['incomes'];

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'description',
    ];

    protected $searchable = [
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
