<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Workitem extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $fillable = ['name','user_id'];

    public $translatable = ['name'];

    //Other Functions
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }

    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->translatedFormat('M d, Y');
    }

    //Relations 
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function contracts()
    {
        return $this->hasMany('App\Models\Contract', 'workitem_id', 'id');
    }

    public function subcontractors()
    {
        return $this->belongsToMany(Subcontractor::class, 'subcontractor_workitem', 'workitem_id', 'subcontractor_id');
    }

}
