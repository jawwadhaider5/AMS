<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\TestStatus\Incomplete;

class Task extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'sub_category_id',
        'task_type',
        'ub_type',
        'frequency',
        'imca_reference',
        'description',
        'notes'
    ];

    public function status(){
        $startDate = Carbon::parse($this->start_date);
        $endDate = Carbon::parse($this->expire_date);
        $nowDate = Carbon::now();
        if ( $this->frequency == 0) {
            $statusLabel = 'Certified';
        }
        else if (!$this->expire_date || $this->expire_date == null){
            $statusLabel = 'Incomplete';
        }else if ($nowDate < $startDate) {
            $statusLabel = 'Certified';
        }elseif ($endDate < $nowDate) {
            $statusLabel = 'Expired';
        }else if ($nowDate >= $startDate && $endDate > $nowDate->addDays(31)) {
            $statusLabel = 'Certified';
        } else if ($endDate < $nowDate->addDays(31)) {
            $statusLabel = "Expiring";
        } 
        else {
            $statusLabel = 'Expired';
        }
        return $statusLabel; 
    }

    public function statusLabel($certified, $expired, $expiring, $incomplete){

        if ($incomplete > 0){
            return 'Incomplete';
        }else if ($expired > 0) {
            return 'Expired';
        }else if ($expired == 0 && $expiring > 0) {
            return 'Expiring';
        }else if ($expired == 0 && $expiring == 0 && $certified > 0) {
            return 'Certified';
        }else
        {
            return 'Incomplete';
        }
       
        // if ($certified > $expired && $certified > $expiring && $certified > $incomplete) {
        //     return 'Certified';
        // }elseif ($expired > $certified && $expired > $expiring && $expired > $incomplete) {
        //     return 'Expired';
        // }else if ($expiring > $certified && $expiring > $expired && $expiring > $incomplete) {
        //     return 'Expiring';
        // } else if ($incomplete > $certified && $incomplete > $expiring && $incomplete > $expired) {
        //     return "Incomplete";
        // } 
        // else {
        //     return 'Incomplete';
        // } 
    }
    
    
    public function imca(){
        return $this->hasOne(IMCAReference::class,'id','imca_reference');
    }
    public function tasktype(){
        return $this->belongsTo(TaskType::class,'task_type');
    }
    // public function category(){
    //     return $this->hasOne(Category::class,'id','category_id');
    // }
    // public function subcategory(){
    //     return $this->hasOne(SubCategory::class,'id','sub_category_id');
    // }
      public function asset(){
        return $this->belongsTo(Assets::class,'asset_id');
    }
    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }
    public function subcategory(){
        return $this->belongsTo(SubCategory::class,'sub_category_id');
    } 
    public function spreadcategorytype(){
        return $this->belongsTo(SpreadCategoryType::class,'spread_category_type_id');
    }
    
    public function asset_files(){
        return $this->hasMany(AssetFile::class,'task_id');
    }

    public function spares(){
        return $this->hasMany(Spares::class, 'task_id');
    }

}