<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpreadCategory extends Model
{
    protected $table = 'spread_category';
    use HasFactory;

    protected $fillable = [
        'system_id',
        'system_description',
        'manufraturer',
        'class_system',
        'class_name',
        'model_number',
        'containerized_system',
        'manufacture_date',
        'container_number',
        'purchased_date',
        'size',
        'data_sheet',
        'certificates',
        'manual'
    ];

    public function system(){
        return $this->belongsTo(System::class,'system_id');
    }

    public function systemtype(){
        return $this->belongsTo(SystemType::class, 'system_type_id');
    }

    public function spreadcategorytype(){
        return $this->hasMany(SpreadCategoryType::class,'spread_category_id');
    }

    public function status(){ 
        $assets = Assets::where('spread_category_id', $this->id)->whereNotNull('spread_category_id')->get(); 
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

    public function assets(){
        return $this->hasMany(Assets::class);
    } 

    public function tasks(){
        return $this->hasMany(Task::class);
    } 


}

