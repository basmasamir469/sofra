<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function edit()
    {
        $settings=Setting::first();
        return view('settings.edit',compact('settings'));
    }
    public function update(Request $request)
    {          
         $settings=Setting::first();
         $accounts=$request->accounts;
         $new_accounts=[];
         foreach($accounts as $key => $value){
            //    $new_accounts=[
            //     $key=>$value
            //    ];
          $new_accounts[$request[$key]] = $value ;
      }
        //  $settings->accounts=$new_accounts;
        //  $settings->save();
         $settings->update([
             'about_app'=>$request->about_app,
		 	'app_comission'=>$request->app_comission,
		 	'accounts'=>$new_accounts,
		 	'fb_link'=>$request->fb_link,
		 	'insta_link'=>$request->insta_link,
		 	'tw_link'=>$request->tw_link,
		 	'phone'=>$request->phone
               ]);
        flash('Settings updated successfully')->success();
        return redirect()->route('settings.edit');
    }

}
