<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Expense extends ApiModel
{
    use SoftDeletes, LogsActivity, FullTextSearch;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title', 'payment', 'date', 'note', 'amount', 'expense_type_id', 'project_id'
    ];

    protected $searchable = [
        'title'
    ];

    public function expense_type()
    {
        return $this->belongsTo(ExpenseType::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function materials()
    {
        return $this->belongsToMany(Material::class)->withPivot('quantity', 'price')->withTimestamps();
    }

    public function people()
    {
        return $this->belongsToMany(Person::class)->withTimestamps();
    }
}
