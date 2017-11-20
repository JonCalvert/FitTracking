<?php 
    use App\Http\Controllers\WorkoutController;
    date_default_timezone_set('America/Detroit');
?>
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">My Workouts</div>
                <div class="panel-body">                    
                    <div clas="row"><h3>Hello {{ Auth::user()->name }}! </h3></div>                     
                </div>                
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row title-bar" id="nav">
                        <div class="hmenu" name="AddNewWorkout"><a onclick="switchTab('AddNewWorkout')">Add New Workout</a></div>
                        <div class="hmenu" name="AddWorkout"><a onclick="switchTab('AddWorkout')">Add Workout</a></div>
                        <div class="hmenu" name="DisplayWorkouts"><a onclick="switchTab('DisplayWorkouts')">Display Workouts</a></div>                        
                    </div>   
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body">                   
                
                    <div id="AddNewWorkout" style="margin-top:15px;">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/addnewworkout') }}">
                            {{ csrf_field() }}                        
                            <label for="workoutname" class="col-md-2 ">Workout name:</label>
                            <div class="col-md-6">
                                <input id="workoutname" type="text" class="form-control" name="workoutname" placeholder="Workout name">
                            </div>        
                            <hr>
                            <div class="col-md-6 col-md-offset-4" style="margin-top:15px;">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-btn fa fa-plus"></i> Add Workout
                                </button>
                                <button type="reset" class="btn btn-default">
                                    <i class="fa fa-btn fa fa-ban"></i>Cancel
                                </button>
                            </div>
                        </form>    
                    </div>
                    <div id="AddWorkout" style="display:none">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/addworkout') }}">
                            {{ csrf_field() }} 
                            <h2>Add Workout</h2>
                            <select class='my_dropdown form-control' name='workouts' style="display:inline-block; width: 30%" required>
                                <option selected disabled value=''>Select One</option>                            
                                <?php
                                    $workouts = WorkoutController::getWorkouts();
                                    foreach($workouts as $workout)
                                    {
                                        echo '<option value='.$workout->workout_id.'>'.$workout->workout_name.'</option>';                                        
                                    }                        
                                ?>
                            </select>
                            
                            <input id="workoutweight" type="number" class="form-control" name="workoutweight" style="display:inline-block; width: 30%;" placeholder="Weight">                           
                            <input id="workoutreps" type="number" class="form-control" name="workoutreps" style="display:inline-block; width: 30%;" placeholder="Number of repetitions">
                            <textarea id="workoutcomment" type="text" class="form-control" name="workoutcomment" style="margin-top:15px; max-width: 90.6%; resize:none;" placeholder="Add any relevant comments" ></textarea>
                            <hr>
                            <div class="form-group" stlye="margin-top:15px;">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa fa-plus"></i> Submit!
                                    </button>
                                    <button type="reset" class="btn btn-default">
                                        <i class="fa fa-btn fa fa-ban"></i> Clear form!
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="DisplayWorkouts" style="display:none">
                        <h2>Display Workouts</h2>
                        <?php
                            $workouts = WorkoutController::getUserWorkouts( Auth::user()->id, date('Y-m-d'));
                            if (count($workouts) > 0)
                            {
                        ?>                           
                                <?php
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
                                ?>
                                    
                        <?php
                            }
                            else
                            {
                        ?>
                                <h3 style="padding: 10px 10px; text-align:left;">It seems that there is nothing here yet!</h3>
                        <?php
                            }
                        ?>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
