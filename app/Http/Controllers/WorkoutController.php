<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

use Auth;

use App\Http\Requests;

date_default_timezone_set('America/Detroit');

class WorkoutController extends Controller
{
   /*
    *
    * section for inserting data into the database
    *
    */
    public function addnew(Request $request)
    {
        $name = $request->input('workoutname');        
        
        DB::table('workouts')->insert(
            ['workout_name' => $name]
        );
        
        return view('workouts');        
    }
    public function add(Request $request)
    {       
        $id = $request->get('workouts');
        DB::table('userworkouts')->insert(
            ['workout_id' => $id,
             'user_id' =>  Auth::user()->id ,
             'date' => date('Y-m-d G:i:s')
            ]
        );        
        return view('workouts');        
    }
    /*
    *
    *   end section
    *
    */   
    
    /*
    *
    *   section for retrieving data from the database
    *
    */
    public static function getWorkouts()
    {        
        $workouts = DB::table('workouts')->get();        
        return $workouts;
    }
    public static function getUserWorkouts($userId, String $date)
    {        
        $workouts = DB::table('userworkouts')
            ->join('workouts','userworkouts.workout_id', '=', 'workouts.workout_id')
            ->where('date','like', '%'.$date.'%')
            ->where('user_id', $userId)
            ->get();
        
        return $workouts;
    }
    public static function getAllUserWorkouts()
    {        
        $workouts = DB::table('userworkouts')
            ->join('workouts','userworkouts.workout_id', '=', 'workouts.workout_id')
            ->where('user_id', Auth::user()->id)
            ->groupBy('date')
            ->orderBy('date','DESC')  
            ->get();
        
        return $workouts;
    }

    
    /*
    *
    *   end section
    *
    */
}
