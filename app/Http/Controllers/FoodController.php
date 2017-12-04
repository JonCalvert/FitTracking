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
        $i=1;        
        while($request->get('food'.$i))
        {
            $id = $request->get('food'.$i);        
            DB::table('userfoods')->insert(
                ['food_id' => $id,
                 'user_id' =>  Auth::user()->id ,
                 'date' => date('Y-m-d G:i:s')
                ]
            );
            $i++;
        }      
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
    public static function getUserFoodTotal($userId, String $date)
    {        
        
        $foods = DB::table('userfoods')
            ->join('foods','userfoods.food_id', '=', 'foods.food_id')            
            ->select(DB::raw("sum(foods.food_calories) as calories, sum(foods.food_protein) as protein, sum(foods.food_carbs) as carbs, sum(foods.food_fats) as fats"))
            ->where('date','like', '%'.$date.'%')
            ->where('user_id', $userId)
            ->get();

        return $foods;
    }
    
    public static function getAllUserFoods()
    {        
        $userId = Auth::user()->id;
        $foods = DB::table('userfoods')
            ->join('foods','userfoods.food_id', '=', 'foods.food_id')
            ->where('user_id', $userId)
            ->groupBy('date')
            ->orderBy('date','DESC')            
            ->get();
        
        return $foods;
    }
    
    public static function listfoods($date)
    {   
             
        $foods = FoodController::getUserFoods( Auth::user()->id, $date);
        if (count($foods) > 0)
        {
            echo '<tr><td><b>Food<b></td><td><b>Calories</b></td><td><b>Protein</b></td><td><b>Carbs</b></td><td><b>Fats</b></td></tr>';    
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
            $foodTotals = FoodController::getUserFoodTotal( Auth::user()->id, $date);
            echo '<tr>';
                echo '<td style="width:30%"> </td>';
                echo '<td style="width:15%"><b>'.reset($foodTotals)->calories.'</b></td>';
                echo '<td style="width:15%"><b>'.reset($foodTotals)->protein.'</b></td>';
                echo '<td style="width:15%"><b>'.reset($foodTotals)->carbs.'</b></td>';
                echo '<td style="width:15%"><b>'.reset($foodTotals)->fats.'</b></td>';
            echo '</tr>';
        }
        else
        {
            echo '<p style="text-align:left;">It seems that there is nothing here!</p>';
        }
        
    }
    
    
    
    

    
    /*
    *
    *   end section
    *
    */
}
