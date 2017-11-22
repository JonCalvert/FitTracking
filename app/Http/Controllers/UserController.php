<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

date_default_timezone_set('America/Detroit');

class UserController extends Controller
{
    
    
    
    public static function getUserActivity($userId)
    {
        $currentDate = '';
        
        $foods = DB::table('userfoods')
            ->select((DB::raw("foods.food_name as name, userfoods.date as date"))) 
            ->join('foods','userfoods.food_id', '=', 'foods.food_id')
            ->where('user_id', $userId)
            ->orderBy('date','DESC');
        
        $activities = DB::table('userworkouts')
            ->select((DB::raw("workouts.workout_name as name, userworkouts.date as date")))
            ->join('workouts','userworkouts.workout_id', '=', 'workouts.workout_id')
            ->where('user_id', $userId)  
            ->orderBy('userworkouts.workout_id')  
            ->union($foods)             
            ->orderBy('date','DESC')
            ->get();
        foreach($activities as $activity)
        {   
            $isNewDate = explode(" ",$currentDate)[0] != explode(" ",$activity->date)[0];
            if ( $isNewDate )
            {
                if ( reset($activities) != $activity )
                    echo '</div></div>';
                echo '<div class="panel panel-default" ><div class="panel-body">';
                echo '<div class="col-md-12" style="margin:5px 0px 5px -15px;text-align:left;"><b>'.explode(" ", $activity->date)[0].'</b></div>';
            }
            $currentDate = explode(" ",$activity->date)[0];
            echo '<p style="clear:both">'.$activity->name.'</p>';                                                                                                     
        }   
    }
}
