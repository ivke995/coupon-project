<?php

namespace App\Models;

use App\Models\Used;
use App\Models\Coupon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Email extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [];

    public function coupon() {
        return $this->hasOne(Coupon::class);
    }

    public function used() 
    {
        return $this->belongsTo(Used::class, 'id', 'email_id');
    }

}
