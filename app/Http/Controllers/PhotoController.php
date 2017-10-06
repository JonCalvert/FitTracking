<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Auth;

use DB;

class PhotoController extends Controller
{
    public static function getPhotos()
    {        
        $photos = DB::table('photos')
            ->where('user_id', Auth::user()->id)
            ->get();
        return $photos;
    }
    public static function getdefault()
    {        
        $photo = DB::table('photos')
            ->where('user_id', Auth::user()->id)
            ->where('photo_default', 1)
            ->get();
        return $photo;
    }
    
    
    public static function addphoto(Request $request)
    {
        $photo = $request->file('image');
        $name = $photo->getClientOriginalName();
        $type = $photo->getClientOriginalExtension();
        $size = $photo->getSize();
        
        $destinationPath = '/var/www/html/TrackFit/public/images';
        $savePath = '/images/'.$photo->getClientOriginalName();
        $path = $photo->move($destinationPath,$photo->getClientOriginalName());
        
        
        
        DB::table('photos')->insert(
            ['user_id' =>  Auth::user()->id,
             'photo_name' =>  $name,
             'photo_type' => $type,
             'photo_size' => $size,
             'photo_url' => $savePath,
             'photo_default' => 0
            ]);   
            
        
        
        return view('photos');    
    }
    
    public static function removephoto($photoId)
    {        
        DB::table('photos')->where('photo_id',$photoId)->delete();            
        return view('photos');    
    }
    
    public static function setdefault($photoId)
    {        
        
        DB::table('photos')->where('photo_default',1)->update(array(
            'photo_default' => 0
        ));  
        
        DB::table('photos')->where('photo_id',$photoId)->update(array(
            'photo_default' => 1
        ));            
        return view('photos');    
    }
    
    
}
