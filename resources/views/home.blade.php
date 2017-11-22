<?php
    use App\Http\Controllers\PhotoController;
    use App\Http\Controllers\UserController;
?>

@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">
                    <div class="row">
                        
                            <?php
                                $default = PhotoController::getdefault();
                                if ( count($default) > 0 )
                                {
                                    foreach($default as $photo)
                                    {
                                        $url = $photo -> photo_url;
                                        echo '<a href="/profile">
                                            <img class="profimg" src="'.$url.'" />
                                        </a>';
                                    }
                                }
                                else
                                {
                            ?>
                                    <a href="/profile">
                                        <img class="profimg" src="{{ URL::to('/images') }}/default.jpg" />
                                    </a>
                            <?php
                                }
                            ?>
                        
                    </div>                        
                    <div class="panel panel-default" id="act" style="display:block;" >
                        <div class="panel-heading">Activity</div>
                        <div class="panel-body" style="width:98%; margin:0px 1% 0px 1%;">
                            <?php

                                $activity = UserController::getUserActivity(Auth::user()->id);
                                echo $activity;
                            ?>                                       
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection