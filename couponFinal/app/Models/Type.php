<?php

namespace App\Models;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Type extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function coupon() {
        return $this->belongsTo(Coupon::class);
    }
}
