<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Income extends ApiModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title', 'date', 'note', 'amount', 'income_type_id', 'project_id'
    ];

    public function income_type()
    {
        return $this->belongsTo(IncomeType::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
