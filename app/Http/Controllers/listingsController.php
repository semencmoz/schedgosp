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
        $depts =  \App\depts::where('id','<>',1)->where('id','<>',5)->get();
        return view('listings.viewlistings', ['alllistings' => $listings, 'alldepts' =>$depts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $depts =  \App\depts::where('id','<>',1)->where('id','<>',5)->get();
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
            'phone'=>'required',
        ]);
        //отправляем данные в базу

        /*определяем квоту, в которую поместить запись*/
        $quota_id = $this->get_avaliableQuota($request->get('in_date'),-1, $request->get('dep_id'));
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
            'phone' => $request->get('phone'),
            'signed_off' => false
        ]);
        if ($listing->save()){
            $quota = \App\quotas::find($listing->quota_id);
            $quota->qttyused++;
            $quota->save();
            $listings = \App\listings::all();
            foreach ($listings as $listing){
                $dept = \App\depts::find($listing->dep_id);
                $listing->dep_id = $dept->name;
            }
            $depts =  \App\depts::where('id','<>',1)->where('id','<>',5)->get();
            return view('listings.viewlistings', ['alllistings' => $listings, 'success' => 'Плановая госпитализация создана','alldepts' =>$depts]);
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
        $depts =  \App\depts::where('id','<>',1)->where('id','<>',5)->get();
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
        $this->validate($request,[
            'dep_id'=>'required',
            'patient_name'=>'required',
            'in_date'=>'required',
            'phone'=>'required',
        ]);
        //отправляем данные в базу

        /*определяем квоту, в которую поместить запись*/
        $quota_id = $this->get_avaliableQuota($request->get('in_date'),$id, $request->get('dep_id'));
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
        //отправляем данные в базу
        $listing = \App\listings::find($id);
        $listing->dep_id = $request->get('dep_id');
        $listing->patient_name = $request->get('patient_name');
        $listing->in_date = $request->get('in_date');
        $listing->quota_id = $quota_id;
        $listing->phone = $request->get('phone');
        if ($listing->save()){
            $listings = \App\listings::all();
            foreach($listings as $listing){
                $listing = \App\depts::find($listing->dep_id);
                $listing->dep_id = $listing->name;
            }
            $depts =  \App\depts::where('id','<>',1)->where('id','<>',5)->get();
            return view('listings.viewlistings', ['alllistings' => $listings, 'success' => 'Госпитализация успешно изменена','alldepts' =>$depts]);
        }
        else{
            return view('listings.createlistings');
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
        $quota = \App\quotas::find((\App\listings::find($id)->quota_id));
        $quota->qttyused--;
        $quota->save();
        \App\listings::destroy($id);
        $listings = \App\listings::all();
        foreach($listings as $listing){
            $dept = \App\depts::find($listing->dep_id);
            $listing->dep_id = $dept->name;
        }
        $depts =  \App\depts::where('id','<>',1)->where('id','<>',5)->get();
        return view('listings.viewlistings', ['alllistings' => $listings, 'success' => 'Госпитализация успешно удалена','alldepts' =>$depts]);
    }

    public function ajpost(Request $request)
    {

        $response = \App\listings::where('in_date',$request->date)->where('dep_id',$request->dep_id)->get();
        foreach($response as $listing){
            $dept = \App\depts::find($listing->dep_id);
            $listing->dep_id = $dept->name;
            $listing->in_date = date("d.m.y", strtotime($listing->in_date));
        }
        return response()->json(['listings'=>$response->toJson()]);
    }

    /*функция для валидации введённых параметров квот -
    * есть ли квоты на данную дату
    * есть ли квоты для данного отделения
    */
    public function get_avaliableQuota($date_in,$id,$dep_id){//date_in - дата поступления; $id - если больше 0, айди записи, что мы редактируем ; dep_id - департамент
        /*берём список квот для даты и отееления*/
        //$res=\App\quotas::where('date_start','<=',$date_in)->
        //where('date_end','>=',$date_in)->where('dep_id',$dep_id)->get();//изменения в БД

        //если мы редактируем запись
        if ($id>0)
            return (\App\listings::find($id))->quota_id;// если на квота, которую мы создали не забита планами, то всё норм

        $res=\App\quotas::where('date',$date_in)->where('dep_id',$dep_id)->get();

        if (!isset($res)) return null; //если у отделения нет квот на данную дату, возвращаем ноль
        if (count($res)==1) {//если квота одна, возвращаем её
                $res1=$res->first();
                if ($res1->qtty > $res1->qttyused)
                    return $res1->id; // если на квота, которую мы создали не забита планами, то всё норм
                else return null;//иначе возвращаем ноль
        }
        $viable = array();
        //если квот, которые можно открыть на данную дату для данного отделения несколько, фильтруем их
        // и возвращаем одну
        foreach ($res as $quota){
            //если запись создаётся с нуля, возвращаем для квоты количество доступных записей
            if($quota->qttyused < $quota->qtty)
                //если запись на эту квоуу доступна, добавляем квоту в список с количеством доступных для квоты записей
                $viable = array_add($viable, $quota->id, $quota->qttyused);
        }

        if (count($viable)<1) return null; //если в списке нет доступных записей, то возвращаем ноль
        if (count($viable)==1) return key($viable);//если в списке оолько одна запись, то возвращаем ид квоты
        if (count($viable)>1) { //если записей больше одной, сортируем по количеству свободных записей и возвращаем
            // квоту с наименьшем количеством свободных слотов
            asort($viable);//сортируем по наименьшей оставшейся квоте
            reset($viable);//ставим указатель на первый эеемент
            return key($viable);//возвращаем ключ(айди квоты) первого элемента массива
        }
    }
}
