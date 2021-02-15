<?php

namespace App\Http\Controllers\Admin;

use App\Country;
use App\Http\Controllers\Controller;
use App\SellingZone;
use App\State;
use Illuminate\Http\Request;
use Gate;
class SellingZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('zone_access'),403,"Not allowed");
        $d['title']="Add Selling Zone";
        $d['zone']=SellingZone::with('getCountry','getState','getCity')->get();
        $d['country']=Country::get();
        return view('admin.selling-zone.index',$d);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        SellingZone::updateOrCreate(['id'=>$request->id],[
            'country'=>$request->country,
            'state'=>$request->state,
            'city'=>$request->city,
            'postal_code'=>$request->pincode,
            'shipping_charge'=>$request->ship,
        ]);
        return redirect('admin/selling-zone')->with('msg','Selling zone added or updated successfully');
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
        abort_if(Gate::denies('zone_edit'),403,"Not allowed");
        $d['title']="Edit Selling Zone";
        $d['edzone']=SellingZone::where('id',$id)->with('getCountry','getState','getCity')->first();
        $d['country']=Country::get();
        return view('admin.selling-zone.index',$d);
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
        abort_if(Gate::denies('zone_delete'),403,"Not allowed");
        SellingZone::destroy($id);
        return response()->json(['msg'=>"removed successfully"]);
    }
    public function getState($id)
    {
        $st=Country::findOrFail($id)->state;
        return json_encode($st);
     }
     public function getCity($id)
     {
         $st=State::findOrFail($id)->city;
         return json_encode($st);
 
     }
}
