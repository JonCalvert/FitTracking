<?php
    use App\Http\Controllers\PhotoController;
    use App\Http\Controllers\WorkoutController;
    use App\Http\Controllers\FoodController;


?>

@extends('layouts.app')

@section('content')
<script type="text/javascript">
    function showElement(ele = "")
    {
        $("#"+ele).css("display","block");
        
    }
    function hideElement(ele = "")
    {
        
        $("#"+ele).css("display","none");
        
    }
    function switchTab(tab = "")
    {
        tabs = $(".row .title-bar").find(".hmenu");
        
        for (var i =0; i<tabs.length-1; i++)
        {
            var name = $(tabs[i]).attr("name");
            name == tab ? showElement(name) : hideElement(name);
           
        }    
        
        
    }
    
    
</script>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Profile</div>
                <div class="panel-body">
                    <div class="row">
                        <?php
                            $default = PhotoController::getdefault();
                            if ( count($default) > 0 )
                            {
                                foreach($default as $photo)
                                {
                                    $url = $photo -> photo_url;
                                    echo '<a href="'.$url.'" data-lightbox="defaultpicture">
                                        <img class="profimg" src="'.$url.'" />
                                    </a>';
                                }
                            }
                            else
                            {
                        ?>
                                <a href="{{ URL::to('/images') }}/default.jpg" data-lightbox="defaultpicture">
                            <img class="profimg" src="{{ URL::to('/images') }}/default.jpg" style="width:25%;padding-bottom:10px;"/>
                        </a>
                        <?php
                            }
                        ?>                        
                        
                        
                        
                        <h3 style="display:inline-block; vertical-align:bottom; padding-left: 20px;">{{ Auth::user()->name }}! </h3>
                    </div>
                    <div class="row title-bar" id="nav">
                        <div class="hmenu" name="act"><a onclick="switchTab('act')">Activity</a></div>
                        <div class="hmenu" name="ab"><a onclick="switchTab('ab')">About</a></div>
                        <div class="hmenu" name="ph"><a href="{{ url('/photos') }}">Photos</a></div>                        
                    </div>                   
                </div>
            </div>
            <div class="panel panel-default" id="act" style="display:block">
                <div class="panel-heading">Activity</div>
                <div class="panel-body">
                    <div class="row">
                        <?php
                            $currentDate = '';
                            $foods = FoodController::getAllUserFoods();
                            foreach($foods as $food)
                            {   
                                $isNewDate = explode(" ",$currentDate)[0] != explode(" ",$food->date)[0];
                                if ( $isNewDate )
                                {
                                    echo '<b>'.$food->date.'</b><br>';
                                }
                                $currentDate = explode(" ",$food->date)[0];
                                echo $food->food_name.'<br>';                                                                                                     
                            }   
                        ?>  
                        <?php
                            $currentDate = '';
                            $workouts = WorkoutController::getAllUserWorkouts();
                            foreach($workouts as $workout)
                            {   
                                $isNewDate = explode(" ",$currentDate)[0] != explode(" ",$workout->date)[0];
                                if ( $isNewDate )
                                {
                                    echo '<b>'.$workout->date.'</b><br>';
                                }
                                $currentDate = explode(" ",$workout->date)[0];
                                echo $workout->workout_name.'<br>';                                                                                                     
                            }   
                        ?>      
                    </div>                                   
                </div>
            </div>
            <div class="panel panel-default" id="ab" style="display:none">
                <div class="panel-heading">About</div>
                <div class="panel-body">
                    <div class="row">
                        <?php
                           
                        ?>                        
                    </div>                                   
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
