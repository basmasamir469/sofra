<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users=User::paginate(10);
        return view('users.index',compact('users'));
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $roles=Role::all();
        return view('users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        //
        $request['password']=bcrypt($request['password']);
        $user=User::create($request->all());
        $user->assignRole($request->input('roles'));
        flash('user created successfully')->success();
        return redirect()->route('users.index');
        
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
        $user=User::findOrFail($id);
        return view('users.show',compact('user'));
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
        $user=User::findOrFail($id);
        $roles=Role::all();
        return view('users.edit',compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        //
        $user=User::findOrFail($id);
        $input=$request->all();
        if(!empty($request->password)){
            $input['password']=bcrypt($input['password']);
        }
        else{
            $input=Arr::except($input,array('password'));
        }
        $user->update($input);
        $user->syncRoles($request['roles']);
        flash('user updated successfully')->success();
        return redirect()->route('users.index');

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
        $user=User::findOrFail($id);
        $client->delete();
        flash('user deleted successfully')->success();
        return redirect()->route('users.index');

    }
    public function changePassword()
    {
     return view('users.changePassword');
    }

    public function updatePassword(Request $request){
    $validator=validator()->make($request->all(),[
        'old_password'=>'required',
        'new_password'=>'required|confirmed|min:8'
    ]);
    if($validator->fails()){
        return redirect()->back()->withErrors($validator)->withInput();
    }
    $user=auth()->user();
    if(Hash::check($request->old_password, $user->password)){
        $request['new_password']=bcrypt($request->new_password);
        $user->password=$request['new_password'];
        if(!$user->save()){
            flash('sorry faild to update password')->error();
            return redirect()->back();
        }
        else{
            flash('password updated successfully')->success();
            return redirect()->back();    
        }        

    }
    else{
        flash('old password does not match')->error();
        return redirect()->back();
    }
    }

}
