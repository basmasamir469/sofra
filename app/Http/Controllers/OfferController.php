<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\Resturant;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $offers=Offer::with('resturant')->paginate(10);
        $resturants=Resturant::all();
        return view('offers.index',compact('offers','resturants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        //
        $offers=Offer::query();
        $resturants=Resturant::all();
        $offers=$offers->when($request->filled('resturant_id'),function($q) use($request){
                  return $q->where('resturant_id',$request->resturant_id);
        })->when($request->filled('from'),function($q) use($request){
                  return $q->where('from','>=',$request->from);
        })->when($request->filled('to'),function($q) use($request){
                  return $q->where('from','<=',$request->to);
        })->paginate(10);

        return view('offers.index',compact('offers','resturants'));
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $offer=Offer::findOrFail($id);
        $offer->delete();
        flash('offer deleted successfully')->success();  
        return redirect()->route('offers.index');
    }
}
