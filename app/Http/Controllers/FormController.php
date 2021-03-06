<?php

namespace App\Http\Controllers;

use App\Models\FoodFact;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormController extends Controller
{
    //
    public function index()
    {
        return view('multistepform');
    }

    public function formSubmit(Request $req)
    {

        /* { another way join tables }
        /*DB::table('foods')
                ->join('food_facts', 'foods.id', '=', 'food_facts.food_id')
                ->join('facts', 'food_facts.fact_id', '=', 'facts.id')*/

        /* { get foods by blood type } */
        $getByBlood = FoodFact::getDataFoodFact()
                    ->select('*')
                    ->where('food_facts.blood_type_id', $req->blood_type);

        $datas = $getByBlood->get();


        /* { selecting based on allergies } */
        switch (true) {
            case ($req->cowsmilk_free) :
                $datas = $getByBlood
                    ->where('food_facts.allergy_name_id', '<>', $req->cowsmilk_free) 
                    ->get();
                break;
            
            case ($req->egg_free) :
                $datas = $getByBlood
                    ->where('food_facts.allergy_name_id', '<>', $req->egg_free) 
                    ->get();
                break;

            case ($req->treenut_free) :
                $datas = $getByBlood
                    ->where('food_facts.allergy_name_id', '<>', $req->treenut_free) 
                    ->get();
                break;

            case ($req->peanut_free) :
                $datas = $getByBlood
                    ->where('food_facts.allergy_name_id', '<>', $req->peanut_free) 
                    ->get();
                break;

            case ($req->shellfish_free) :
                $datas = $getByBlood
                    ->where('food_facts.allergy_name_id', '<>', $req->shellfish_free) 
                    ->get();
                break;

            case ($req->wheat_free) :
                $datas = $getByBlood
                    ->where('food_facts.allergy_name_id', '<>', $req->wheat_free) 
                    ->get();
                break;

            case ($req->soy_free) :
                $datas = $getByBlood
                    ->where('food_facts.allergy_name_id', '<>', $req->soy_free) 
                    ->get();
                break;

            case ($req->fish_free) :
                $datas = $getByBlood
                    ->where('food_facts.allergy_name_id', '<>', $req->fish_free) 
                    ->get();
                break;
            
            default:
                
                break;
        }

        /* { mapping data for view } */
        $attrs = [];
        foreach ($datas as $data) {
            $attrs[$data->food_category][] =  $data->food_name;
        }

        foreach ($attrs as $attr => $value) {
            $dataCategories[] = $value;
        }

        return view('formresults', [ 'attrs' => $attrs, 'dataCategories' => $dataCategories]);
    }
}
