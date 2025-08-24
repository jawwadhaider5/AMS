<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubSheet extends Model
{
    use HasFactory;

    protected $guarded = []; 
    protected $table = "sub_sheet"; 

    public function sub_category(){
        return $this->belongsTo(SubCategory::class,'sub_category_id');
    }
    
    public function tasktype(){
        return $this->belongsTo(TaskType::class,'task_type_id');
    }

}