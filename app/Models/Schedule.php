<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
       'date', 'time_from', 'time_to', 'event_id', 'venue', 'address', 'purpose', 'others','sched_type','created_by','created_by_name','assign_to','assign_by','status','is_assign','assign_to_name'
    ];

    public function declinedRequest()
    {
        return $this->hasOne(DeclinedRequest::class);
    }
}
