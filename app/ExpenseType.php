<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class ExpenseType extends ApiModel
{
    use SoftDeletes, LogsActivity, FullTextSearch, CascadeSoftDeletes;

    protected $cascadeDeletes = ['expenses'];

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'description',
    ];

    protected $searchable = [
        'name', 'description',
    ];

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public static function listExpenseTypes()
    {
        return static::orderBy('id', 'DESC')->select('id', 'name')->get();
    }
}
