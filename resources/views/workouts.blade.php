<?php 
    use App\Http\Controllers\WorkoutController;
    date_default_timezone_set('America/Detroit');
    
    if (isset($_POST['functionname']))
    {
        listWorkouts($_POST['arguments'][0]);
    }
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
                <div class="panel-heading" align="center">
                    <div class="row title-bar" id="nav">
                        <div class="hmenu" name="AddNewWorkout" style="width:33%;"><a onclick="switchTab('AddNewWorkout')">Add New Workout</a></div>
                        <div class="hmenu" name="AddWorkout" style="width:33%;"><a onclick="switchTab('AddWorkout')">Add Workout</a></div>
                        <div class="hmenu" name="DisplayWorkouts" style="width:33%;"><a onclick="switchTab('DisplayWorkouts')">Display Workouts</a></div>                        
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
                            <div class="col-md-12" align="center" style="margin-top:15px;">                                
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
                            <select class='my_dropdown form-control' name='workouts' style="display:inline-block; width: 33%" required>
                                <option selected disabled value=''>Select One</option>                            
                                <?php
                                    $workouts = WorkoutController::getWorkouts();
                                    foreach($workouts as $workout)
                                    {
                                        echo '<option value='.$workout->workout_id.'>'.$workout->workout_name.'</option>';                                        
                                    }                        
                                ?>
                            </select>
                            
                            <input id="workoutweight" type="number" class="form-control" name="workoutweight" style="display:inline-block; width: 33%;" placeholder="Weight">                           
                            <input id="workoutreps" type="number" class="form-control" name="workoutreps" style="display:inline-block; width: 33%;" placeholder="Number of repetitions">
                            <textarea id="workoutcomment" type="text" class="form-control" name="workoutcomment" style="margin-top:15px; max-width: 99.6%; resize:none;" placeholder="Add any relevant comments" ></textarea>
                            <hr>
                            <div class="form-group" stlye="margin-top:15px;">
                                <div class="col-md-12" align="center">
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
                        <b style="display:inline-block;">Workouts from:</b>
                        <input type="date" id="workoutDate" class="form-control" value="<?php echo date('Y-m-d'); ?>" onblur="listworkouts()" style="width:25%;display:inline-block;margin-bottom:20px;margin-left:15px;"> 
                        <div id="workouts">
                        
                        </div>
                        
                        
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        var today = $("#workoutDate").val();
        var request = $.get('/workouts/listworkouts/'+today);
        request.done(function(response){    
            $("#workouts").html('');
            $("#workouts").append(response);
        });    
    })
    
    var listworkouts = function(){
        
        var today = $("#workoutDate").val();
        var request = $.get('/workouts/listworkouts/'+today);
        request.done(function(response){
            $("#workouts").html('');
            $("#workouts").append(response);
        });    
    }
    
    
</script>
@endsection
