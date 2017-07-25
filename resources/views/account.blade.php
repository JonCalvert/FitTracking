@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">My Account</div>

                <div class="panel-body">                    
                    <div clas="row"><h3>Hello {{ Auth::user()->name }}! </h3></div>
                        
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
