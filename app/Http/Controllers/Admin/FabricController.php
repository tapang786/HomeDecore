<?php

namespace App\Http\Controllers\Admin;

use App\Fabric;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gate;
class FabricController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('fabric_access'),'403 forbidden');
        $d['title']="Add Fabric Type";
        $d['fab']=Fabric::orderBy('id','desc')->get();
        return view('admin.fabric-setting.index',$d);
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
        Fabric::updateOrCreate(['id'=>$request->id],[
            'name'=>$request->name
        ]);
        return redirect('admin/fabric-setting')->with('msg','Fabric type added or updated successfully');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('fabric_edit'),'403 forbidden');
        $d['title']="Edit Fabric Type";
        $d['edfab']=Fabric::findOrFail($id);
        return view('admin.fabric-setting.index',$d);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('fabric_delete'),'403 forbidden');
        Fabric::destroy($id);
        return response()->json(['msg'=>"removed successfully"]);
    }
}
