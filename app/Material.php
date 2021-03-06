<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Material extends ApiModel
{
    use SoftDeletes, LogsActivity, FullTextSearch;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'unity', 'description', 'price', 'material_type_id'
    ];

    protected $searchable = [
        'name'
    ];

    public function material_type()
    {
        return $this->belongsTo(MaterialType::class);
    }

    public function expenses()
    {
        return $this->belongsToMany(Expense::class);
    }

    public static function listMaterials()
    {
        return static::orderBy('id', 'DESC')->select('id', 'name')->get();
    }
}
