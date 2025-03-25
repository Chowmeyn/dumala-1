<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeclinedRequest extends Model
{
    use HasFactory;

    protected $fillable = ['schedule_id', 'referred_priest_id', 'reason'];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    public function referredPriest()
    {
        return $this->belongsTo(User::class, 'referred_priest_id');
    }
}