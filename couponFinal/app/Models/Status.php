<?php

namespace App\Models;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Status extends Model
{
    use HasFactory;
    public $timestamps = false;


    public function coupon() {
        return $this->belongsToMany(Coupon::class, 'id', 'status_id');
    }
}
