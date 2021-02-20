<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = ['name','origin_name','extension','type'];

    public function attachable()
    {
        return $this->morphTo();
    }

    public function setPath($val)
    {
        if($this->type == 'logo')
            return $val = 'uploads/logos/'.$val;
        else
        return $val = 'uploads/attachs/'.$val;
    }

    public function remvoeExt($val)
    {
        return $val = preg_replace('/\..+$/', '', $val);
    }
    
    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('M d, Y');
    }

    public function subcontractor()
    {
        return $this->belongsTo('App\Models\subcontractor', 'subcontractor_id', 'id');
    }
}
