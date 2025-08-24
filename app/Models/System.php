<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    use HasFactory;
    public function systemtype(){
        return $this->hasOne(SystemType::class,'id','system_type_id');
    }
    public function location(){
        return $this->belongsTo(Locations::class,'system_description');
    }
    public function spreadcategory(){
        return $this->hasMany(SpreadCategory::class,'system_id');
    }

    public function spreadcategorytype(){
        return $this->hasMany(SpreadCategory::class,'system_id');
    }
    public function tasks(){
        return $this->hasMany(Task::class,'system_id','id');
    }
    public function assets(){
        return $this->hasMany(Assets::class,'spread_id','id');
    }
    public function projects(){
        return $this->hasMany(Project::class,'spread_id');
    }
}
