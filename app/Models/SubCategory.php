<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SubCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'name',
        'description',
        'added_by',
    ];
    // public function category(){
    //     return $this->belongsTo(Category::class,'id','category_id');
    // }
    
    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }
    public function assets(){
        return $this->hasMany(Assets::class,'sub_category_id', 'id');
    }

    public function sheets(){
        return $this->hasMany(SubSheet::class,'sub_category_id', 'id');
    }

    public function tasks(){
        return $this->hasMany(Task::class,'sub_category_id', 'id');
    }

    public function pretasks(){
        return $this->hasMany(PreTask::class,'sub_category_id', 'id');
    }

    public function tasktype(){
        return $this->belongsTo(TaskType::class,'sheet_number');
    }

    public function status(){ 
        $assets = Assets::where('sub_category_id', $this->id)->whereNotNull('spread_category_id')->get(); 
        $certified_count = $expired_count = $expiring_count = $incomplete_count = 0;
        foreach ($assets as $asset) {
            if ($asset) { 
                if ($asset->status() == 'Certified') {
                    $certified_count++;
                } else if ($asset->status() == 'Expired') {
                    $expired_count++;
                } else if ($asset->status() == 'Expiring') {
                    $expiring_count++;
                } else {
                    $incomplete_count++;
                } 
            } else {
                $incomplete_count++;
            }
        }
        $temptask =new Task();
        $statusLabel = $temptask->statusLabel($certified_count, $expired_count, $expiring_count, $incomplete_count);
        return $statusLabel;
    }
    public function assetCount(){ 

        $auth_id = Auth::user()->id;
        $session = SystemSession::where('user_id', $auth_id)->first();
        $sysid = System::where('id', $session->system_id)->first();


        $assetscount = Assets::where('sub_category_id', $this->id)->whereNotNull('spread_category_id')->where('status', null)->where('spread_id', $sysid->id)->count();
        return $assetscount;
    }
    public function assetCount2($id){ 
 
        $assetscount = Assets::where('sub_category_id', $this->id)->whereNotNull('spread_category_id')->where('status', null)->where('spread_category_id', $id)->count();
        return $assetscount;
    }
}