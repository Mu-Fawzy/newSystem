<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subcontractor extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name','email','phone','address','bio','status','user_id'];

    //Other Functions
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }

    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->translatedFormat('M d, Y');
    }
    
    public function statusSubcontractor() {
        if ($this->status == 1) {
            return __('content.active');
        }else {
            return __('content.not active');
        }
    }
    //Relations 
    public function attachs()
    {
        return $this->morphMany(Attachment::class, 'attachable')->whereType('attachs');
    }

    public function attachlogo()
    {
        return $this->morphOne(Attachment::class, 'attachable')->whereType('logo');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function contracts()
    {
        return $this->hasMany('App\Models\Contract', 'subcontractor_id', 'id');
    }

    public function worksites()
    {
        return $this->belongsToMany(Worksite::class, 'subcontractor_worksite', 'subcontractor_id', 'worksite_id');
    }

    public function workitems()
    {
        return $this->belongsToMany(Workitem::class, 'subcontractor_workitem', 'subcontractor_id', 'workitem_id');
    }

}