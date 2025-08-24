<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerProfile extends Model
{
    use HasFactory;
    public function customers(){
        return $this->belongsTo(Customer::class,'assigned_to','id');
    }
}
