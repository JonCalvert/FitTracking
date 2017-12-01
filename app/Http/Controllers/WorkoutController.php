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
        $i=1;
        while($request->get('workouts'.$i))
        {
            $id = $request->get('workouts'.$i);
            $weight = $request->get('workoutweight'.$i);
            $reps = $request->get('workoutreps'.$i);
            $comment = $request->get('workoutcomment'.$i);

            DB::table('userworkouts')->insert(
                ['workout_id' => $id,
                 'user_id' =>  Auth::user()->id ,
                 'date' => date('Y-m-d G:i:s'),
                 'workout_reps' => $reps,
                 'workout_weight' => $weight,
                 'workout_comment' => $comment
                ]
            );  
            $i++;
        }
            
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
            ->orderBy('userworkouts.workout_id')
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
    
    public static function listworkouts($date)
    {   
        $workouts = WorkoutController::getUserWorkouts( Auth::user()->id, $date);
        if (count($workouts) > 0)
        {
            $currentWorkout = reset($workouts)->workout_name;
            $workout = reset($workouts);
            while( $workout != null )
            {
                echo '<div class="panel panel-default"><div class="panel-body">';
                echo $workout->workout_name;
                echo '<table style="width:75%">
                    <tbody>
                        <tr>
                            <td width="25%"><b>Reps</b></td>
                            <td width="25%"><b>Weight</b></td>
                            <td width="40%"><b>Comments</b></td>
                        </tr>';

                while( $workout != null && $workout->workout_name == $currentWorkout)
                {

                    echo '<tr>';
                    echo '<td>'.$workout->workout_reps.'</td>';
                    echo '<td>'.$workout->workout_weight.'</td>';
                    echo '<td>'.$workout->workout_comment.'</td>';
                    echo '</tr>';
                    $workout = next($workouts);
                }  
                echo '</tbody></table></div></div>';

                if( $workout )
                    $currentWorkout = $workout->workout_name;
                else 
                    break;                                      
            }                                         
        }
        else
        {
            echo '<p style="text-align:left;">It seems that there is nothing here yet!</p>';
        }

    }

    
    /*
    *
    *   end section
    *
    */
}
