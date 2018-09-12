<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\depts;
class deptsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $depts = \App\depts::all();

        return view('depts.viewdepts', ['alldepts' => $depts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('depts.createdepts');
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
        ]);
        //отправляем данные в базу
        $dept = new depts([
            'name' => $request->get('name'),
        ]);
        if ($dept->save()){
            $depts = \App\depts::all();
            return view('depts.viewdepts', ['alldepts' => $depts, 'success' => 'Подаазделение успешно создано']);
        }
        else{
            return view('depts.createdepts');
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
        $depts = depts::find($id);
        return view('depts.editdept', compact('dept','id'));
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
        $this->validate($request,[
            'name'=>'required',
        ]);
        //отправляем данные в базу
        $dept = \App\depts::find($id);
        $dept->name = $request->get('name');
        if ($dept->save()){
            $depts = \App\depts::all();
            return view('depts.viewdepts', ['alldepts' => $depts, 'success' => 'Подразделение успешно изменено']);
        }
        else{
            return view('depts.createdepts');
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
        \App\depts::destroy($id);
        $depts = \App\depts::all();
        return view('depts.viewdepts', ['alldepts' => $depts, 'success' => 'Подразделение успешно удалено']);
    }
}
