<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $roles=Role::paginate(10);
        return view('roles.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $permissions=Permission::all();
        return view('roles.create',compact('permissions'));
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
        $validator=validator()->make($request->all(),
        [
            'name'=>'required|unique:roles,name',
            'permission'=>'required'
        ]
        );
        $role=Role::create([
            'name'=>$request->name
        ]);
        $role->syncPermissions($request->input('permission'));
        flash('role created successfully')->success();
        return redirect()->route('roles.index');

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
        $role=Role::findOrFail($id);
        return view('roles.show',compact('role'));
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
        $role=Role::findOrFail($id);
        $permissions=Permission::all();
        return view('roles.edit',compact('role','permissions'));
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
        $validator=validator()->make($request->all(),
        [
            'name'=>'required|unique:roles,name',
            'permission'=>'required'
        ]);
        $role=Role::findOrFail($id);
        $role->update([
            'name'=>$request->name
        ]);
        $role->syncPermissions($request->input('permission'));
        flash('role updated successfully')->success();
        return redirect()->route('roles.index');
        
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
        $role=Role::findOrFail($id);
        $role->delete();
        flash('role deleted successfully')->success();
        return redirect()->route('roles.index');
    }
}
