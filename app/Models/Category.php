<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'parent_cat_id',
        'name',
        'description',
        'added_by',
    ];
    public function systemtype(){
        return $this->hasOne(SystemType::class,'id','parent_cat_id');
    }
    public function subcategories(){
        return $this->hasMany(SubCategory::class,'category_id','id')->orderBy('display_id');
    }
    public function tasks(){
        return $this->hasMany(Task::class,'category_id','id');
    }
    public function assets(){
        return $this->hasMany(Assets::class,'category_id','id');
    }

    public function pretasks(){
        return $this->hasMany(PreTask::class,'category', 'id');
    }
}