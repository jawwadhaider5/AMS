<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreTask extends Model
{
    use HasFactory;
    protected $table = 'predefine_tasks';

    protected $fillable = [
        'system_type',
        'category',
        'sub_category_id',
        'task_type',
    ];

    public function subcategory(){
        return $this->belongsTo(SubCategory::class,'sub_category_id');
    }
    public function category_name(){
        return $this->belongsTo(Category::class,'category');
    }
    public function system_type_name(){
        return $this->belongsTo(SystemType::class,'system_type');
    }

    public function tasktype(){
        return $this->belongsTo(TaskType::class,'task_type');
    }
}
