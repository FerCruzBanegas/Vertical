<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class ApiModel extends Model
{
	public function getFormatDate($date)
    {
        return Carbon::parse($date)->format('d/m/Y');
    }

    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('Y-m-d H:i:s');
    }
    
    public function getUpdatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('d/m/Y');
    }
}