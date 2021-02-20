<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['contract_number','user_id','subcontractor_id','workitem_id','worksite_id'];

    public function contract()
    {
        return $this->morphOne(Attachment::class, 'attachable')->whereType('contract');
    }

    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->translatedFormat('M d, Y');
    }

    public function attachinvoices()
    {
        return $this->morphMany(Attachment::class, 'attachable')->whereType('invoices');
    }

    public function subcontactor()
    {
        return $this->belongsTo(Subcontractor::class, 'subcontractor_id', 'id');
    }

    public function worksite()
    {
        return $this->belongsTo(Worksite::class, 'worksite_id', 'id');
    }

    public function workitem()
    {
        return $this->belongsTo(Workitem::class, 'workitem_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
    

}
