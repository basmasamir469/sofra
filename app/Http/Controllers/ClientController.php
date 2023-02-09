<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Client;
use App\Models\Resturant;
use Illuminate\Http\Request;

class ClientController extends Controller
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
    $resturants=Resturant::all();
    $clients=Client::with('district')->paginate(10);
    return view('clients.index',compact('resturants','cities','clients'));
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
    public function store(clientRequest $request)
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
        $clients=Client::query();
        $cities=City::all();
        $resturants=Resturant::all();
        $clients=$clients->when($request->filled('active'),function($q) use($request){
                  return $q->where('active',$request->active);
        })->when($request->filled('city_id'),function($q) use($request){
                  return $q->whereHas('district',function($q) use($request){
                    return $q->where('city_id',$request->city_id);
          });
    })->paginate(10);

        return view('clients.index',compact('clients','cities','resturants'));
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
        $client=Client::findOrFail($id);
        return view('clients.show',compact('client'));
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
        $client=Client::findOrFail($request->client_id);
        $client->active=$request->active;
        $client->save();
        return response()->json(['active'=>$client->active]);

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
        $client=Client::findOrFail($id);
        $client->delete();
        flash('client deleted successfully')->success();
        return redirect()->route('clients.index');

    }
}
