<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Project extends ApiModel
{
	use SoftDeletes, LogsActivity;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'uuid', 'name', 'location', 'comments', 'start_date', 'end_date', 'state', 'project_type_id',
    ];

    // public function getStartDateAttribute($date)
    // {
    //     return $this->getFormatDate($date);
    // }

    public function getIncomeAttribute() 
    { 
        $total = 0; 

        foreach($this->incomes as $income){ 
           $total += $income->amount; 
        } 

        return $total;
    }

    public function project_type()
    {
        return $this->belongsTo(ProjectType::class);
    }

    public function incomes()
    {
        return $this->hasMany(Income::class);
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public static function listProjects()
    {
        return static::orderBy('name')->select('id', 'name');
    }
}
