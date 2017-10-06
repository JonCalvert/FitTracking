
@extends('layouts.app')


@section('content')
<?php
    use App\Http\Controllers\PhotoController;
    $userid = Auth::user()->id;
    $photos = PhotoController::getPhotos();
    
    
?>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">
                    <div class="row">
                        <?php
                            if ( count($photos) > 0 )
                            {
                                foreach($photos as $photo)
                                {
                                    $url = $photo -> photo_url;
                        ?>                        
                                    <a href="<?php echo $url; ?>" data-lightbox="defaultpicture" data-title = "<a href='/photo/removephoto/<?php echo $photo->photo_id; ?>'>Remove Picture</a>
                                                                                                               <a href='/photo/setdefault/<?php echo $photo->photo_id; ?>'>Set as default</a>">
                                        <img class="profimg" src="<?php echo $url; ?>"  style="width:25%;padding-bottom:10px;"/>                                        
                                    </a>
                        <?php
                                        
                                }     
                            }
                            else
                            {
                                echo '<h3 style="padding: 10px 10px; text-align:center;">It seems that there is nothing here yet!</h3>';
                            }
                            
                        ?>
                        <div align="center">
                            {{ Form::open(array('route' => 'photo.addphoto', 'action' => 'PhotoController@addphoto', 'method' => 'POST', 'files' => true)) }}
                            {{Form::file('image')}}
                            <br>
                            {!! Form::submit('Submit')!!}
                            {!! Form::reset('Cancel') !!}
                            {!! Form::close() !!}
                        </div>
                        <!--
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/addphoto') }}">
                            {{ csrf_field() }}                             
                            <div align="center">
                                <input type="file" id="myFile">
                                <input type="submit" class="btn btn-default" value="Upload Image" name="submit" >
                                <input type="button" class = "btn btn-default" onclick="myFunction()" value="Cancel" />
                            </div>                            
                        </form>  
-->
                    </div>                                     
                </div>
            </div>
        </div>
    </div>
</div>
@endsection