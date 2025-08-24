<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpreadCategoryType extends Model
{
    use HasFactory;
    protected $table = 'spread_category_types';
    use HasFactory;

    protected $fillable = [
        'spread_category_id',
        'system_id',
        'status',
        'value',
        'file',
       
    ];


    public function tasks(){
        return $this->hasMany(Task::class);
    } 

    public function spreadcategory(){
        return $this->belongsTo(spreadcategory::class, 'id', 'spread_category_id');
    }
}
