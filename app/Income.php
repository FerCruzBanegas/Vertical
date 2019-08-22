<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Income extends ApiModel
{
    use SoftDeletes, LogsActivity, FullTextSearch;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title', 'payment', 'date', 'note', 'amount', 'income_type_id', 'project_id', 'account_id'
    ];

    protected $searchable = [
        'title'
    ];

    public function income_type()
    {
        return $this->belongsTo(IncomeType::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
