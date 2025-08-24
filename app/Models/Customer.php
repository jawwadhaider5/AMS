<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    public function customer_profiles(){
        return $this->hasMany(CustomerProfile::class,'assigned_to','id');
    }
}
