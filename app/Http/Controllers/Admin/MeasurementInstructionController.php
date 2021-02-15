<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\MeasurementInstruction;
use App\ProductSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Gate;
class MeasurementInstructionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      abort_if(Gate::denies('measure_access'),'403 forbidden');
      $d['title']="Add Measurement Instruction";
      $d['bodyp']=ProductSize::where('varient_category','Custom Size')->get();
      $d['meas']=MeasurementInstruction::orderBy('custom_size','asc')->get();
      return view('admin.product-setting.measurement-instruction',$d);
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
        if($request->id!=""){
            $mi= MeasurementInstruction::findOrFail($request->id);
            $mi->title=$request->title;
            $mi->custom_size=$request->body;
            $mi->content=$request->content;
            if($request->has("imgfile")){
                if(Storage::exists(url('public/measurement').'/'.$mi->image)){
                    Storage::delete(url('public/measurement').'/'.$mi->image);
                }
                $mi->image=$request->file('imgfile')->move('public/measurement',$request->file('imgfile')->getClientOriginalName());
            }
             $mi->update();  
           }else{
            $mi=new MeasurementInstruction();
            $mi->title=$request->title;
            $mi->custom_size=$request->body;
            $mi->content=$request->content;
            if($request->has('imgfile')){
               $mi->image=$request->file('imgfile')->move('public/measurement',$request->file('imgfile')->getClientOriginalName());
            }
            $mi->save();
       }
       return redirect('admin/measurement-instruction')->with('msg','Measurement instruction added successfully');
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
        abort_if(Gate::denies('measure_access'),'403 forbidden');
        $d['title']="Edit Measurement Instruction";
        $d['editmeas']=MeasurementInstruction::findOrFail($id);
        return view('admin.product-setting.measurement-instruction',$d);
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
        abort_if(Gate::denies('measure_delete'),'403 forbidden');
        MeasurementInstruction::destroy($id);
        return response()->json(['msg'=>"removed successfully"]);
    }
}
