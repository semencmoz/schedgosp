<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\quotas;
use App\depts;

class quotasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $quotas = \App\quotas::all();
        foreach ($quotas as $quota){
            $dept = \App\depts::find($quota->dep_id);
            $quota->dep_id = $dept->name;
        }
        return view('quotas.viewquotas', ['allquotas' => $quotas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $depts =  \App\depts::all();
        return view('quotas.createquotas',['alldepts' =>$depts]);
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
            'dep_id'=>'required',
            'qtty'=>'required',
            'date_start'=>'required',
            'date_end'=>'required'
        ]);
        //отправляем данные в базу
        $quota = new quotas([
            'dep_id' => $request->get('dep_id'),
            'qtty' => $request->get('qtty'),
            'date_start' => $request->get('date_start'),
            'date_end' => $request->get('date_end'),
        ]);
        if ($quota->save()){
            $quotas = \App\quotas::all();
            return view('quotas.viewquotas', ['allquotas' => $quotas, 'success' => 'Квота создана']);
        }
        else{
            return view('quotas.createquotas');
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
