<?php

namespace App\Http\Controllers\Admin;

use App\Color;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gate;
class ColorCustomizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('color_access'),'403 forbidden');
        $d['title']="Add Color";
        $d['color']=Color::orderBy('id','desc')->get();
        return view('admin.color.index',$d);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request)
    {
        abort_if(Gate::denies('color_store'),'403 forbidden');
        $clr= new Color;  
        if(! $request->id!=''){
      
            $clr->colorname=$request->name;
        if($request->has('clrplt') && $request->clropt=="pallate"){
           $clr->color_code=$request->clrplt;
           $clr->color_image='';
        }
        if($request->has('imgfile') && $request->clropt=="custom"){
           $clr->color_image=$request->file('imgfile')->move('public/colors',$request->file('imgfile')->getClientOriginalName());
           $clr->color_code='';
        }
        $clr->save();
        return json_encode($clr);
        }
        
        else{
        $clr=Color::findOrFail($request->id);
        $clr->colorname=$request->name;
        if($request->has('clrplt') && $request->clropt=="pallate"){
           $clr->color_code=$request->clrplt;
           $clr->color_image='';
        }
        if($request->has('imgfile') && $request->clropt=="custom"){
           $clr->color_image=$request->file('imgfile')->move('public/colors',$request->file('imgfile')->getClientOriginalName());
           $clr->color_code='';
        }
        $clr->update();
        }
     
        return json_encode($clr);
    }

    public function edit($id)
    {
        abort_if(Gate::denies('color_edit'),'403 forbidden');
        $colors=Color::findOrFail($id);
        return response()->json(['clr'=>$colors]);
    }

    public function destroy($id)
    {
        abort_if(Gate::denies('color_delete'),'403 forbidden');
        Color::destroy($id);
        return response()->json(['msg'=>"removed successfully"]);
    }
}
