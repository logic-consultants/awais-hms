<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transport;

class TransportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transports = Transport::select('*','transports.id AS id')
                                ->join('transport_vehicles','transport_vehicles.id','=','transports.vehicle_id')
                                ->where('transports.school_id',schoolId())
                                ->orderBy('transports.id', 'DESC')
                                ->get();
        return view('backend.transport.transports.transport-list',compact('transports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.transport.transports.transport-add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'road_name' => 'required',
            'vehicle_id' => 'required',
            'road_fare' => 'required|numeric',
            'note' => 'nullable',
        ]);

        if (checkSchoolId('transport_vehicles',$request->vehicle_id) != schoolId()) {
            return redirect()->back()->with('error','access denied');
        }

        $transport = new Transport();
        $transport->school_id = schoolId();
        $transport->road_name = $request->road_name;
        $transport->vehicle_id = $request->vehicle_id;
        $transport->road_fare = $request->road_fare;
        $transport->note = $request->note;
        $transport->save();

        return redirect('transports')->with('success', _lang('Information has been added'));
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
        $transport = Transport::find($id);

        if ($transport->school_id != schoolId()) {
            return redirect()->back()->with('error','access denied');
        }
        return view('backend.transport.transports.transport-edit',compact('transport'));
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
        $this->validate($request, [
            'road_name' => 'required',
            'vehicle_id' => 'required',
            'road_fare' => 'required|numeric',
            'note' => 'nullable',
        ]);

        if (checkSchoolId('transport_vehicles',$request->vehicle_id) != schoolId()) {
            return redirect()->back()->with('error','access denied');
        }

        $transport = Transport::find($id);

        if ($transport->school_id != schoolId()) {
            return redirect()->back()->with('error','access denied');
        }
        $transport->road_name = $request->road_name;
        $transport->vehicle_id = $request->vehicle_id;
        $transport->road_fare = $request->road_fare;
        $transport->note = $request->note;
        $transport->save();

        return redirect('transports')->with('success', _lang('Information has been updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transport = Transport::find($id);

        if ($transport->school_id != schoolId()) {
            return redirect()->back()->with('error','access denied');
        }
        $transport->delete();
        return redirect('transports')->with('success', _lang('Information has been deleted'));
    }
}
