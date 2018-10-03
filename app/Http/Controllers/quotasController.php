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
        $depts =  \App\depts::all();
        return view('quotas.viewquotas', ['allquotas' => $quotas, 'alldepts' =>$depts]);
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
            'date'=>'required',
        ]);
        //отправляем данные в базу
        $quota = new quotas([
            'dep_id' => $request->get('dep_id'),
            'qtty' => $request->get('qtty'),
            'date' => $request->get('date'),
            'qttyused' => 0
        ]);
        if ($quota->save()){
            $quotas = \App\quotas::all();
            foreach ($quotas as $quota){
                $dept = \App\depts::find($quota->dep_id);
                $quota->dep_id = $dept->name;
            }
            $depts =  \App\depts::all();
            return view('quotas.viewquotas', ['allquotas' => $quotas, 'success' => 'Квота создана', 'alldepts' =>$depts]);
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
        $quota = quotas::find($id);
        $dept = \App\depts::find($quota->dep_id);
        $quota->dep_id = $dept->name;
        $depts =  \App\depts::all();
        return view('quotas.editquotas', compact('quota','id'), ['alldepts' =>$depts]);
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
            'dep_id'=>'required',
            'qtty'=>'required',
            'date'=>'required',
        ]);
        //отправляем данные в базу
        $quota = \App\quotas::find($id);
        $qtty = $request->get('qtty');
        if ($quota->qttyused > $qtty){
            $depts =  \App\depts::all();
            return view('quotas.editquotas', compact('quota','id'), ['alldepts' =>$depts, 'success' => 'Количество мест не может быть меньше, чем количество уже запланировыанных госпитализаций']);
        }
        $quota->dep_id = $request->get('dep_id');
        $quota->qtty = $qtty;
        $quota->date = $request->get('date');
        if ($quota->save()){
            $quotas = \App\quotas::all();
            foreach ($quotas as $quota){
                $dept = \App\depts::find($quota->dep_id);
                $quota->dep_id = $dept->name;
            }
            $depts =  \App\depts::all();
            return view('quotas.viewquotas', ['alldepts' =>$depts,'allquotas' => $quotas, 'success' => 'Квота успешно изменена']);
        }
        else{
            return view('quotas.editquotas', [ 'success' => 'Создание квоты не вышло']);
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
        \App\quotas::destroy($id);
        $quotas = \App\quotas::all();
        foreach($quotas as $quota){
            $dept = \App\depts::find($quota->dep_id);
            $quota->dep_id = $dept->name;
        }
        $depts =  \App\depts::all();
        return view('quotas.viewquotas', ['allquotas' => $quotas, 'success' => 'Квота успешно удалена', 'alldepts' =>$depts]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ajpost(Request $request)
    {
        $response = \App\quotas::where('date',$request->date)->where('dep_id',$request->dep_id)->get();
        if (isset($response)) return response()->json(['querys'=>$response->toJson()]);
    }
}
