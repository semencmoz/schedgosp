<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\listings;
use App\depts;
use App\quotas;

class listingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $listings = \App\listings::all();
        foreach ($listings as $listing){
            $dept = \App\depts::find($listing->dep_id);
            $listing->dep_id = $dept->name;
        }
        return view('listings.viewlistings', ['alllistings' => $listings]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $depts =  \App\depts::all();
        return view('listings.createlistings',['alldepts' =>$depts]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'dep_id'=>'required',
            'patient_name'=>'required',
            'in_date'=>'required',
        ]);
        //отправляем данные в базу

        /*определяем квоту, в которую поместить запись*/
        $quota_id = $this->get_avaliableQuota($request->get('in_date'));
        if ($quota_id==null)
        {
            $error = \Illuminate\Validation\ValidationException::withMessages(
                [
                    'Нет свободных квот' => 'Квот на указанную дату либо нет, либо они закончились',
                ]
            );
            throw $error;
        }
        /****************
         * определяем квоту, в которую поместить запись
         */
        $listing = new listings([
            'dep_id' => $request->get('dep_id'),
            'patient_name' => $request->get('patient_name'),
            'in_date' => $request->get('in_date'),
            'quota_id' => $quota_id,
        ]);
        if ($listing->save()){
            $listings = \App\listings::all();
            foreach ($listings as $listing){
                $dept = \App\depts::find($listing->dep_id);
                $listing->dep_id = $dept->name;
            }
            return view('listings.viewlistings', ['alllistings' => $listings, 'success' => 'Квота создана']);
        }
        else{
            return view('listings.createlistings');
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
        $listing = listings::find($id);
        $dept = \App\depts::find($listing->dep_id);
        $listing->dep_id = $dept->name;
        $depts =  \App\depts::all();
        return view('listings.editlistings', compact('listing','id'), ['alldepts' =>$depts]);
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
        \App\listings::destroy($id);
        $listings = \App\listings::all();
        foreach($listings as $listing){
            $dept = \App\depts::find($listing->dep_id);
            $listing->dep_id = $dept->name;
        }
        return view('listings.viewlistings', ['alllistings' => $listings, 'success' => 'Госпитализация успешно удалена']);
    }

    public function get_avaliableQuota($date_in){
        $res=\App\quotas::where('date_start','<=',$date_in)->where('date_end','>=',$date_in)->get();
        if (!isset($res)) return null;
        if (count($res)==1) return $res->first()->id;
        $wiable = array();
        foreach ($res as $quota){
            $listings_with_that_quota = \App\listings::where('quota_id', $quota->id)->count();
            if($listings_with_that_quota < $quota->qtty)
                $wiable = array_add($wiable, $quota->id, $listings_with_that_quota);

        }

        if (count($wiable)<1) return null;
        if (count($wiable)==1) return key($wiable);
        if (count($wiable)>1) {
            asort($wiable);//сортируем по наименьшей оставшейся квоте
            reset($wiable);//ставим указатель на первый эеемент
            return key($wiable);//возвращаем ключ(айди квоты) первого элемента массива
        }

    }
}
