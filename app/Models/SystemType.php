<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemType extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];
    public function system(){
        return $this->hasMany(System::class,'system_type_id');
    }


    public function categories(){
        return $this->hasMany(Category::class, 'parent_cat_id')->orderBy('display_id');
    }

    public function spreadcategories(){
        return $this->hasMany(SpreadCategory::class, 'system_type_id');
    }

 
}