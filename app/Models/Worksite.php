<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worksite extends Model
{
    use HasFactory;

    protected $fillable = ['name','owner','user_id'];

    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->translatedFormat('M d, Y');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function contracts()
    {
        return $this->hasMany('App\Models\Contract', 'worksite_id', 'id');
    }

    public function subcontractors()
    {
        return $this->belongsToMany(Subcontractor::class, 'subcontractor_worksite', 'worksite_id', 'subcontractor_id');
    }

}
