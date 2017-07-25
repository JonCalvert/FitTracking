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
                    <ul class="nav nav-tabs" id="myTab" role="tablist" style="float:none">                        
                        <li class="active"><a data-toggle="tab" href="#AddNewWorkout" role="tab">Add New Workout</a></li>
                        <li><a data-toggle="tab" href="#AddWorkout" role="tab">Add Today's Workout</a></li>
                        <li><a data-toggle="tab" href="#DisplayWorkouts" role="tab">Show Today</a></li>
                    </ul>
                </div>                
                <div class="tab-content">
                    <div id="AddNewWorkout" class="tab-pane fade in active">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/addnewworkout') }}">
                            {{ csrf_field() }}                        
                            <label for="workoutname" class="col-md-4 control-label">Workout name</label>
                            <div class="col-md-6">
                                <input id="workoutname" type="text" class="form-control" name="workoutname" placeholder="Workout name">
                            </div>                                   

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa fa-plus"></i> Add Workout
                                    </button>
                                </div>
                            </div>
                        </form>    
                    </div>
                    <div id="AddWorkout" class="tab-pane fade in">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/addworkout') }}">
                            {{ csrf_field() }} 
                            <h2>AddWorkout</h2>
                            <select class='my_dropdown' name='workouts' required>
                                <option selected disabled value=''>Select One</option>                            
                                <?php
                                    $workouts = WorkoutController::getWorkouts();
                                    foreach($workouts as $workout)
                                    {
                                        echo '<option value='.$workout->workout_id.'>'.$workout->workout_name.'</option>';                                        
                                    }                        
                                ?>
                            </select>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa fa-plus"></i> Add Workout
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="DisplayWorkouts" class="tab-pane fade in">
                        <h2>DisplayWorkouts</h2>
                        <table>
                            <tbody>
                                <tr>
                                    <td>Workout</td>
                                    <td>Sets</td>
                                    <td>Reps</td>
                                    <td>Weight</td>
                                </tr>
                                <?php
                                    $workouts = WorkoutController::getUserWorkouts( Auth::user()->id, date('Y-m-d'));
                                    foreach($workouts as $workout)
                                    {
                                        echo '<tr>';
                                            echo '<td style="width:30%">'.$workout->workout_name.'</td>';
                                            echo '<td style="width:15%">'.$workout->workout_sets.'</td>';
                                            echo '<td style="width:15%">'.$workout->workout_reps.'</td>';
                                            echo '<td style="width:15%">'.$workout->workout_weight.'</td>';
                                        echo '</tr>';
                                    }    
                                ?>
                            </tbody>
                        </table>                        
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
