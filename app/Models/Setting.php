<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_name',
        'email',
        'phone_no',
        'country',
        'address',
        'logo',
        'fav_icon',
        'meta_title',
        'meta_description',
    ];
}
