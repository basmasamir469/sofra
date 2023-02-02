<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Resturant;
use Illuminate\Http\Request;
use App\Http\Requests\PaymentRequest;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    $resturants=Resturant::all();
    $payments=Payment::paginate(10);
    return view('payments.index',compact('payments','resturants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $resturants=Resturant::all();
        return view('payments.create',compact('resturants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaymentRequest $request)
    {
        //
        $payment=Payment::create($request->all());
        flash('payment created successfully')->success();
        return redirect()->route('payments.index');
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
        $payments=Payment::query();
        $resturants=Resturant::all();
        $payments=$payments->when($request->filled('resturant_id'),function($q) use($request){
                  return $q->where('resturant_id',$request->resturant_id);
        })->when($request->filled('from'),function($q) use($request){
                  return $q->where('created_at','>=',$request->from);
        })->when($request->filled('to'),function($q) use($request){
                  return $q->where('created_at','<=',$request->to);
        })->paginate(10);

        return view('payments.index',compact('payments','resturants'));
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
        $resturants=Resturant::all();
        $payment=Payment::findOrFail($id);
        return view('payments.edit',compact('payment','resturants'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PaymentRequest $request, $id)
    {
        //
        $payment=Payment::findOrFail($id);
        $payment->update($request->all());
        flash('payment updated successfully')->success();
        return redirect()->route('payments.index');

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
        $payment=Payment::findOrFail($id);
        $payment->delete();
        flash('payment deleted successfully')->success();
        return redirect()->route('payments.index');

    }
}
