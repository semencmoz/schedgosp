<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\listings;
use App\depts;

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
        $quota_id = 0;
        /****************
         * определяем квоту, в которую поместить запись
         */
        $listing = new listings([
            'dep_id' => $request->get('dep_id'),
            'patient_name' => $request->get('patient_name'),
            'in_date' => $request->get('in_date'),
            'date_end' => $quota_id,
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
