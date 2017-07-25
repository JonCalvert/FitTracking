<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

use Auth;

use App\Http\Requests;

date_default_timezone_set('America/Detroit');

class FoodController extends Controller
{
    /*
    *
    * section for inserting data into the database
    *
    */
    public function addnew(Request $request)
    {
        $name = $request->input('foodname');        
        $cals = $request->input('foodcals');        
        $protein = $request->input('foodprotein');        
        $carbs = $request->input('foodcarbs');   
        $fats = $request->input('foodFats');
        
        DB::table('foods')->insert(
            ['food_name' => $name,
             'food_calories' => $cals,
             'food_protein' => $protein,
             'food_carbs' => $carbs,
             'food_fats' => $fats
            ]
        );
        
        return view('foods');        
    }
    public function add(Request $request)
    {       
        $id = $request->get('food');
        
        DB::table('userfoods')->insert(
            ['food_id' => $id,
             'user_id' =>  Auth::user()->id ,
             'date' => date('Y-m-d G:i:s')
            ]
        );
        
        return view('foods');        
    }
    /*
    *
    *   end section
    *
    */   
    
    /*
    *
    *   section for retrieving data from the database
    *
    */
    public static function getFoods()
    {        
        $foods = DB::table('foods')->get();        
        return $foods;
    }
    public static function getUserFoods($userId, String $date)
    {        
        /*$foods = DB::table('userfoods')->where('user_id', $userId)
            ->where('date','like', '%'.$date.'%')
         ->get();     
        */
        $foods = DB::table('userfoods')
            ->join('foods','userfoods.food_id', '=', 'foods.food_id')
            ->where('date','like', '%'.$date.'%')
            ->where('user_id', $userId)
            ->get();
        
        return $foods;
    }
    

    
    /*
    *
    *   end section
    *
    */
}
