<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

date_default_timezone_set('America/Detroit');

class UserController extends Controller
{
    /*
        get activity of user from $userId
        if workouts or foods have been added since last update,
        update activity table and display the most current activity of the user
    */
    public static function getUserActivity($userId)
    {       
        
        $lastUpdated = DB::table('lastUpdated')            
            ->where('user_id', $userId)
            ->select('date')
            ->first();     
        if ($lastUpdated) $lastUpdated=$lastUpdated->date;   
        
        $ftime = DB::table('userfoods')
            ->where('user_id', $userId)
            ->select('date')
            ->orderBy('date','desc')
            ->first();
        if ($ftime) $ftime=$ftime->date;
        
        $wtime = DB::table('userworkouts')            
            ->where('user_id', $userId)            
            ->select('date')        
            ->orderBy('date','desc')
            ->first();
        if ($wtime) $wtime=$wtime->date;
        
        
        $maxtime = max( $ftime, $wtime );   
        if ( $maxtime > $lastUpdated )
        {
            DB::select('call getUserFoodActivity(?)',array($userId));
            DB::select('call getUserWorkoutActivity(?)',array($userId));
        }
        
        
        $result = DB::table('t2')            
            ->orderBy('date','DESC')
            ->orderBy('type')
            ->distinct()
            ->get();
            
        return $result;
        

    }
}