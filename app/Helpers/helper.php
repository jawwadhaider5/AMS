<?php

use App\Models\Setting;
use App\Models\SubCategory;
use App\Models\Task;
use Carbon\Carbon;

function web_logo()
{
    $data = Setting::where('id', 1)->first();
    return $data->logo;
}
function fav_icon()
{
    $data = Setting::where('id', 1)->first();
    return $data->fav_icon;
}
function meta_description()
{
    $data = Setting::where('id', 1)->first();
    return $data->meta_description;
}
function meta_title()
{
    $data = Setting::where('id', 1)->first();
    return $data->meta_title;
}
function getStatus($id)
{

    $data = Task::where('system_id', $id)->get();
    $statusCounts = [
        'Expired' => 0,
        'Expiring' => 0,
        'Certified' => 0,
        'Incomplete' => 0,
    ];
    if ($data->isEmpty()) {

        return "Incomplete";
    }
    foreach ($data as $key => $value) {



        if ($value) {
            // Assuming start_date and end_date are stored in the database as date strings or Carbon date instances
            $startDate = Carbon::parse($value->start_date);

            $endDate = Carbon::parse($value->expire_date);
            $now = Carbon::now();

            if ($now->between($startDate, $endDate)) {
                // Today's date is between the start and end date
                $statusLabel = 'Expiring';
            } elseif ($now->lt($startDate)) {
                // Today's date is before the start date
                $statusLabel = 'Certified';
            } else {
                // Today's date is after the end date
                $statusLabel = 'Expired';
            }
        } else {
            // Handle case when task is not found
            $statusLabel = 'Incomplete';
        }

        // Increment the count for the status
        $statusCounts[$statusLabel]++;
    }

    // Get the status with the highest count
    $maxStatus = array_keys($statusCounts, max($statusCounts))[0];
    return $maxStatus;
}
