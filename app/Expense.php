<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Expense extends ApiModel
{
    use LogsActivity, FullTextSearch;

    // protected $cascadeDeletes = ['materials'];

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'title', 'payment', 'date', 'note', 'amount', 'expense_type_id', 'project_id', 'account_id', 'user_id'
    ];

    protected $searchable = [
        'title'
    ];

    public function expense_type()
    {
        return $this->belongsTo(ExpenseType::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function materials()
    {
        return $this->belongsToMany(Material::class)->withTrashed()->withPivot('quantity', 'price')->withTimestamps();
    }

    public function people()
    {
        return $this->belongsToMany(Person::class)->withTrashed()->withTimestamps();
    }
}
