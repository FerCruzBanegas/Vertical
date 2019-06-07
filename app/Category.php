<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends ApiModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'description',
    ];

    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    public static function lisCategories()
    {
        return static::orderBy('id', 'DESC')->select('id', 'name')->get();
    }
}
