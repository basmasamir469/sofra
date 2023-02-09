<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Resturant;
use Illuminate\Http\Request;

class ResturantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    $cities=City::all();
    $selected_resturants=Resturant::all();
    $resturants=Resturant::with('district')->paginate(10);
    return view('resturants.index',compact('resturants','cities','selected_resturants'));
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
    public function store(resturantRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        //
        $resturants=resturant::query();
        $cities=City::all();
        $selected_resturants=Resturant::all();
        $resturants=$resturants->when($request->filled('resturant_id'),function($q) use($request){
                  return $q->where('id',$request->resturant_id);
        })->when($request->filled('city_id'),function($q) use($request){
                  return $q->whereHas('district',function($q) use($request){
                    return $q->where('city_id',$request->city_id);
          });
    })->paginate(10);

        return view('resturants.index',compact('resturants','cities','selected_resturants'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $resturant=Resturant::findOrFail($id);
        return view('resturants.show',compact('resturant'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activate(Request $request)
    {
        //
        $resturant=Resturant::findOrFail($request->resturant_id);
        $resturant->active=$request->active;
        $resturant->save();
        return response()->json(['active'=>$resturant->active]);

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
        $resturant=resturant::findOrFail($id);
        $resturant->delete();
        flash('resturant deleted successfully')->success();
        return redirect()->route('resturants.index');

    }
}
