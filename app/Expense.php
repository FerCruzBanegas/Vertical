<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends ApiModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title', 'payment', 'date', 'note', 'amount', 'expense_type_id', 'project_id'
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
        return $this->belongsToMany(Material::class)->withPivot('price');
    }


}
