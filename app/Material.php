<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends ApiModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'unity', 'description', 'price', 'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public static function listMaterials()
    {
        return static::orderBy('id', 'DESC')->select('id', 'name')->get();
    }
}
