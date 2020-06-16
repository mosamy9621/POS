<?php

namespace App\Http\Controllers\Dashboard;

use App\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clients=Client::on();
        if($request->search){
            $clients=$clients->where('name','like','%'.$request->search.'%')
            ->orWhere('phone','like','%'.$request->search.'%')
                ->orWhere('address','like','%'.$request->search.'%')
            ;
        }
        $clients=$clients->latest()->paginate(6);
        return view('dashboard.clients.index',compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('dashboard.clients.create');
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
        $requested_data=$request->validate([
            'name'=>['required'],
            'phone'=>['required'],
            'address'=>['required']
        ]);
        Client::create($requested_data);
        session()->flash('success',__('site.added_successfully'));
        return redirect(route('dashboard.clients.index'));
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
    public function edit(Client $client)
    {
        //
        return view('dashboard.clients.edit',compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $requested_data=$request->validate([
            'name'=>['required'],
            'phone'=>['required'],
            'address'=>['required']
        ]);

        $client->update($requested_data);
        session()->flash('success',__('site.edited_successfully'));
        return redirect(route('dashboard.clients.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {

        $client->delete();
        session()->flash('success',__('site.deleted_successfully'));
        return redirect(route('dashboard.clients.index'));

        //
    }
}
