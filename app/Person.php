<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Person extends ApiModel
{
    use SoftDeletes, LogsActivity, FullTextSearch;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'surnames', 'phone', 'position_id', 'note'
    ];

    protected $searchable = [
        'name', 'surnames',
    ];

    public function expenses()
    {
        return $this->belongsToMany(Expense::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    public static function listPeople()
    {
        return static::orderBy('id', 'DESC')->select('id', 'name')->get();
    }
}
