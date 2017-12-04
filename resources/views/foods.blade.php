<?php 
    use App\Http\Controllers\FoodController;
    date_default_timezone_set('America/Detroit');
?>
@extends('layouts.app')

<style>
    .form-control, label, .btn{
        margin-top: 15px;
    }

    
</style>

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
                        <li><a data-toggle="tab" href="#DisplayFoods" role="tab">Show Foods</a></li>
                        <!--<li><a data-toggle="tab" href="#DailyTotal" role="tab">Show Totals</a></li> -->
                    </ul>
                </div>
                <div class="tab-content">
                    <div id="AddNewfood" class="tab-pane fade in active">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/addnewfood') }}">
                            {{ csrf_field() }}                        
                            <div class="col-md-12">
                                <input id="foodname" type="text" class="form-control" name="foodname" placeholder="Food name">
                            </div>
                            <div class="col-md-6">
                                <input id="foodcals" type="text" class="form-control" name="foodcals" placeholder="Food calories">
                            </div>
                            <div class="col-md-6">
                                <input id="foodprotein" type="text" class="form-control" name="foodprotein" placeholder="Food protein">
                            </div>
                            <div class="col-md-6">
                                <input id="foodcarbs" type="text" class="form-control" name="foodcarbs" placeholder="Food carbs">
                            </div>
                            <div class="col-md-6">
                                <input id="foodFats" type="text" class="form-control" name="foodFats" placeholder="Food fats">
                            </div>                    
                            <div class="form-group">
                                <div class="col-md-12" align="center">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa fa-plus"></i> Add Food
                                    </button>
                                    <button type="reset" class="btn btn-default">
                                        <i class="fa fa-btn fa fa-ban"></i> Clear Form
                                    </button>
                                </div>
                            </div>
                        </form>    
                    </div>
                    <div id="foodsForm" name="foodsForm" style="display:none;">
                        <select class='form-control my_dropdown' name='food' id='my_dropdown'  style="width:50%" required>
                            <option selected disabled value=''>Select One</option>                            
                            <?php
                                $foods = FoodController::getFoods();
                                foreach($foods as $food)
                                {
                                    echo '<option value='.$food->food_id.'>'.$food->food_name.'</option>';                                        
                                }                        
                            ?>
                        </select>
                    </div>                    
                    <div id="Addfoods" class="tab-pane fade in">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/addfood') }}" style="margin-left:15px;">
                            {{ csrf_field() }} 
                            <h2>Add a meal!</h2>                           
                            
                            
                            <button type="button" class="btn btn-default" id="addform">
                                <i class="fa fa-btn fa fa-plus"></i> Add Another Food
                            </button>
                            <button type="button" class="btn btn-default" id="removeform">
                                <i class="fa fa-btn fa fa-minus"></i> Remove a Food
                            </button>
                            <hr>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-btn fa fa-plus"></i> Add Food
                                    </button>
                                    <button type="reset" class="btn btn-default">
                                        <i class="fa fa-btn fa fa-ban"></i> Clear!
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="DisplayFoods" class="tab-pane fade in">
                        <b style="display:inline-block;margin-left:15px;">Foods from:</b>
                        <input type="date" id="foodDate" class="form-control" value="<?php echo date('Y-m-d'); ?>" onblur="listfoods()" style="width:25%;display:inline-block;margin-bottom:20px;margin-left:15px;">                         
                        <div id="foods">
                            <table style="margin-left:15px;margin-bottom:15px;">
                                <tbody id="foodsTable">

                                </tbody>
                            </table>                                
                        </div>
                    </div>
                    <div id="DailyTotal" class="tab-pane fade in">
                        <h2>DailyTotal</h2>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        
        
        var currentItem = 1; 
        $("#addform").click(function() {
            if(currentItem < 10)
            {
                var templateField = $("#foodsForm"),
                    clone = templateField.clone(); 
                clone.find(':input').attr('name', function(i, val) {
                    return val + currentItem;
                });  
                clone.find('select').attr('id', function(i, val) {
                    return val + currentItem;
                }); 
                
                var insertElement = clone.insertBefore(document.getElementById('addform'));
                $(insertElement).attr("style", "display='block'");
                $(insertElement).attr("id", "foodsForm"+currentItem);
                currentItem++;

            }
        });
        $("#addform").click();        
        $("#removeform").click(function() {
            if (currentItem > 2)
            {
                currentItem--;              
                $('#foodsForm'+currentItem).remove();
                return false;
            }
        });
        listfoodsonload();
        
        
         
    }) 
    
    var listfoodsonload = function(){
        var day = $("#foodDate").val();
        var request = $.get('/foods/listfoods/'+day);
        request.done(function(response){    
            $("#foodsTable").html('');
            $("#foodsTable").append(response);
        });   
    }
    
    
    
    var listfoods = function(){
        
        var day = $("#foodDate").val();
        var request = $.get('/foods/listfoods/'+day);
        request.done(function(response){
            $("#foodsTable").html('');
            console.log(response);
            $("#foodsTable").append(response);
        });    
    }
    
    
</script>
@endsection
