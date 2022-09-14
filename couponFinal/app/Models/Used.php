<?php

namespace App\Models;

use App\Models\Email;
use App\Models\Coupon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Used extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function coupon()
    {
        return $this->hasOne(Coupon::class);
    }

    public function email()
    {
        return $this->hasOne(Email::class);
    }
}
