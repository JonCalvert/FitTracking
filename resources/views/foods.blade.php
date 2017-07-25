<?php 
    use App\Http\Controllers\FoodController;
    date_default_timezone_set('America/Detroit');
?>
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">My Foods</div>

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
                        <li class="active"><a data-toggle="tab" href="#AddNewfood" role="tab">Add New Food</a></li>
                        <li><a data-toggle="tab" href="#Addfoods" role="tab">Add Today's Food</a></li>
                        <li><a data-toggle="tab" href="#DisplayFoods" role="tab">Show Today</a></li>
                        <li><a data-toggle="tab" href="#DailyTotal" role="tab">Show Totals</a></li> 
                    </ul>
                </div>
                <div class="tab-content">
                    <div id="AddNewfood" class="tab-pane fade in active">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/addnewfood') }}">
                            {{ csrf_field() }}                        
                            <label for="foodname" class="col-md-4 control-label">Food name</label>
                            <div class="col-md-6">
                                <input id="foodname" type="text" class="form-control" name="foodname" placeholder="Food name">
                            </div>
                            <label for="foodcals" class="col-md-4 control-label">Food calories</label>
                            <div class="col-md-6">
                                <input id="foodcals" type="text" class="form-control" name="foodcals">
                            </div>
                            <label for="foodprotein" class="col-md-4 control-label">Food protein</label>
                            <div class="col-md-6">
                                <input id="foodprotein" type="text" class="form-control" name="foodprotein">
                            </div>
                            <label for="foodcarbs" class="col-md-4 control-label">Food carbs</label>
                            <div class="col-md-6">
                                <input id="foodcarbs" type="text" class="form-control" name="foodcarbs">
                            </div>
                            <label for="foodFats" class="col-md-4 control-label">Food fats</label>
                            <div class="col-md-6">
                                <input id="foodFats" type="text" class="form-control" name="foodFats">
                            </div>                    

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa fa-plus"></i> Add Food
                                    </button>
                                </div>
                            </div>
                        </form>    
                    </div>
                    <div id="Addfoods" class="tab-pane fade in">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/addfood') }}">
                            {{ csrf_field() }} 
                            <h2>AddNewfood</h2>
                            <select class='my_dropdown' name='food' id='my_dropdown' required>
                                <option selected disabled value=''>Select One</option>                            
                                <?php
                                    $foods = FoodController::getFoods();
                                    foreach($foods as $food)
                                    {
                                        echo '<option value='.$food->food_id.'>'.$food->food_name.'</option>';                                        
                                    }                        
                                ?>
                            </select>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa fa-plus"></i> Add Food
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="DisplayFoods" class="tab-pane fade in">
                        <h2>DisplayFoods</h2>
                        <table>
                            <tbody>
                                <tr>
                                    <td>Food</td>
                                    <td>Cal</td>
                                    <td>Protein</td>
                                    <td>Carb</td>
                                    <td>Fat</td>
                                </tr>
                                <?php
                                    $foods = FoodController::getUserFoods( Auth::user()->id, date('Y-m-d'));
                                    foreach($foods as $food)
                                    {
                                        echo '<tr>';
                                            echo '<td style="width:30%">'.$food->food_name.'</td>';
                                            echo '<td style="width:15%">'.$food->food_calories.'</td>';
                                            echo '<td style="width:15%">'.$food->food_protein.'</td>';
                                            echo '<td style="width:15%">'.$food->food_carbs.'</td>';
                                            echo '<td style="width:15%">'.$food->food_fats.'</td>';
                                        echo '</tr>';
                                    }    
                                ?>
                            </tbody>
                        </table>
                        
                    </div>
                    <div id="DailyTotal" class="tab-pane fade in">
                        <h2>DailyTotal</h2>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
