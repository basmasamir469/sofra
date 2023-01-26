<?php

namespace App\Http\Controllers\Api;

use App\Models\Meal;
use App\Models\Resturant;
use App\traits\ImageTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MealController extends Controller
{
    use ImageTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $meals=Meal::where('resturant_id',Auth::guard('api-resturants')->user()->id)->paginate(10);
        return responseJson(1,'success',$meals);
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $meal=Meal::create([
            'name'=>$request->name,
            'price'=>$request->price,
            'price_after_offer'=>$request->price_after_offer,
            'description'=>$request->description,
            'preparation_time'=>$request->preparation_time,
            'image'=>$this->saveImage($request->image,'images/meals'),
            'resturant_id'=>Auth::guard('api-resturants')->user()->id
        ]);
        if($meal){
            return responseJson(1,'meal stored successfully',$meal);
        }
        else{
            return responseJson(0,'faild to store meal please try again');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $meal=Meal::findOrFail($id);
        return responseJson(1,'success',$meal);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function meals($id)
    {
        //
        $resturant=Resturant::findOrFail($id);
        $meals=Meal::where('resturant_id',$resturant->id)->paginate(10);
        if(count($meals)>0){
            return responseJson(1,'success',$meals);
        }
        else{
            return responseJson(1,'no results',$meals);
        }

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
        $meal=Meal::findOrFail($id);
        // if($request->has('file')){
        //     $image=$this->saveImage($request->image,'images/meals');
        // }
        $meal->update([
            'name'=>$request->name,
            'price'=>$request->price,
            'price_after_offer'=>$request->price_after_offer,
            'description'=>$request->description,
            'preparation_time'=>$request->preparation_time,
            'image'=>$this->saveImage($request->image,'images/meals'),
            'resturant_id'=>Auth::guard('api-resturants')->user()->id
        ]);
        if($meal){
            return responseJson(1,'meal updated successfully',$meal);
        }
        else{
            return responseJson(0,'faild to update meal please try again');
        }
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
        $meal=Meal::findOrFail($id);
        if($meal->delete()){
            return responseJson(1,'meal deleted successfully');
        }
        else{
            return responseJson(0,'faild to delete meal please try again');

        }

    }
}
