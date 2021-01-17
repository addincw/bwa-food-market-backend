<?php

namespace App\Http\Controllers\API;

use App\Helpers\Api;
use App\Http\Controllers\Controller;
use App\Models\Food;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filteredBy = [];
        $limit = $request->input('limit', 5);

        $name = $request->input('name');
        $category = $request->input('category');
        $priceFrom = $request->input('price_from');
        $priceTo = $request->input('price_to');
        $rateFrom = $request->input('rate_from');
        $rateTo = $request->input('rate_to');

        $foods = Food::query();

        if($name) {
            $foods->where('name', 'like', "%$name%");
            $filteredBy['name'] = $name;
        }
        if($category) {
            $foods->where('categories', 'like', "%$category%");
            $filteredBy['category'] = $category;
        }
        if($priceFrom) {
            $foods->where('price', '>=', $priceFrom);
            $filteredBy['price_from'] = $priceFrom;
        }
        if($priceTo) {
            $foods->where('price', '<=', $priceTo);
            $filteredBy['price_to'] = $priceTo;
        }
        if($rateFrom) {
            $foods->where('rate', '>=', $rateFrom);
            $filteredBy['rate_from'] = $rateFrom;
        }
        if($rateTo) {
            $foods->where('rate', '<=', $priceTo);
            $filteredBy['rate_to'] = $rateTo;
        }

        return Api::response(200, 'food loaded', [
            "foods" => $foods->paginate($limit),
            "filtered_by" => $filteredBy,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $food = Food::find($id);
        if(empty($food)){
            return Api::response(404, 'food with id '.$id.' can\'t be found');
        }
        
        return Api::response(200, 'food loaded', $food);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
