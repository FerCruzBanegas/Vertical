<?php

namespace App;

// use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Amount extends ApiModel
{
    use LogsActivity;

    protected $fillable = [
        'amount', 'small_box_id',
    ];

    public function small_boxes()
    {
        return $this->belongsTo(SmallBox::class);
    }
}
