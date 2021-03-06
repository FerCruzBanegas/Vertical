<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class MaterialType extends ApiModel
{
    use SoftDeletes, LogsActivity, FullTextSearch, CascadeSoftDeletes;

    protected $cascadeDeletes = ['materials'];

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'description',
    ];

    protected $searchable = [
        'name', 'description',
    ];

    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    public static function listMaterialTypes()
    {
        return static::orderBy('id', 'DESC')->select('id', 'name')->get();
    }
}
