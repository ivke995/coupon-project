<?php

namespace App\Models;

use App\Models\Type;
use App\Models\Used;
use App\Models\Email;
use App\Models\Status;
use App\Models\Subtype;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function type()
    {
        return $this->hasOne(Type::class, 'id', 'type_id');
    }

    public function subtype()
    {
        return $this->hasOne(Subtype::class, 'id', 'subtype_id');
    }

    public function status()
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }

    public function email()
    {
        return $this->belongsTo(Email::class, 'id', 'coupon_id');
    }

    public function used() 
    {
        return $this->belongsTo(Used::class, 'id', 'coupon_id');
    }

    
}
