<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\roles;

class rolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //индекс при обращени по /roles
        $roles = \App\roles::all();

        return view('roles.viewroles', ['allroles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Создание новой роли
        return view('roles.createroles');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //проверяем введённые данные
        $this->validate($request,[
            'name'=>'required',
            'role_type'=>'required',
            'dep_id'=>'required'
        ]);
        //отправляем данные в базу
        $role = new roles([
            'name' => $request->get('name'),
            'role_type' => $request->get('role_type'),
            'dep_id' => $request->get('dep_id'),
        ]);
        if ($role->save()){
            $roles = \App\roles::all();
            return view('roles.viewroles', ['allroles' => $roles, 'success' => 'Роль успешно создана']);
        }
        else{
            return view('roles.createroles');
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
    }
}
