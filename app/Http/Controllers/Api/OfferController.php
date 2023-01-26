<?php

namespace App\Http\Controllers\Api;

use App\Models\Offer;
use App\traits\ImageTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OfferController extends Controller
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
        $offers=Offer::where('resturant_id',app('auth_resturant_id'))->paginate(10);
        return responseJson(1,'offers',$offers);
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
        $offer=Offer::create([
            'offer_name'=>$request->offer_name,
            'description'=>$request->description,
            'image'=>$this->saveImage($request->image,'images/offers'),
            'from'=>$request->from,
            'to'=>$request->to,
            'resturant_id'=>app('auth_resturant_id')
        ]);
        if($offer){
            return responseJson(1,'offer stored successfully',$offer);
        }
        else{
            return responseJson(0,'faild to store offer please try again');
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
        $offer=Offer::findOrFail($id);
        return responseJson(1,'success',$offer);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function offers()
    {
        //
        $offers=Offer::paginate(10);
        if(count($offers)>0){
            return responseJson(1,'success',$offers);
        }
        else{
            return responseJson(1,'no results',$offers);
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
         $offer=Offer::findOrFail($id);
         $offer->update([
            'offer_name'=>$request->offer_name,
            'description'=>$request->description,
            'image'=>$this->saveImage($request->image,'images/offers'),
            'from'=>$request->from,
            'to'=>$request->to,
            'resturant_id'=>app('auth_resturant_id')
        ]);
        if($offer){
            return responseJson(1,'offer updated successfully',$offer);
        }
        else{
            return responseJson(0,'faild to update offer please try again');
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
        $offer=Offer::findOrFail($id);
        if($offer->delete()){
            return responseJson(1,'offer deleted successfully');
        }
        else{
            return responseJson(0,'faild to delete offer please try again');

        }

    }
}
