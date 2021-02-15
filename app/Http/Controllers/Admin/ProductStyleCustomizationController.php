<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ProductStyleCustomization;
use Illuminate\Http\Request;
use Gate;
use Illuminate\Support\Facades\Storage;

class ProductStyleCustomizationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      abort_if(Gate::denies('style_access'),'403 forbidden');
      $d['title']="Add Style Customization";
      $d['style']=ProductStyleCustomization::orderBy('style_group','asc')->get();
      return view('admin.product-setting.style-customization',$d);
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
       if($request->id!="") {
            $ps= ProductStyleCustomization::findOrFail($request->id);
            $ps->style_group=$request->vgroup;
            $ps->style_group_name=$request->vname;
            $ps->design_id=$request->design_id;
            if($request->has("imgfile")){
                if(Storage::exists(url('public/style_customization').'/'.$ps->style_group_icon)){
                    Storage::delete(url('public/style_customization').'/'.$ps->style_group_icon);
                }
                $ps->style_group_icon=$request->file('imgfile')->move('public/style',$request->file('imgfile')->getClientOriginalName());
            }
             $ps->update();  
       }else{
            $ps=new ProductStyleCustomization;
            $ps->style_group=$request->vgroup;
            $ps->style_group_name=$request->vname;
             $ps->design_id=$request->design_id;
            if($request->has('imgfile')){
               $ps->style_group_icon=$request->file('imgfile')->move('public/style',$request->file('imgfile')->getClientOriginalName());
            }
            $ps->save();
       }
       return redirect('admin/product-style-customization')->with('msg','Style customization added successfully');
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
        abort_if(Gate::denies('style_edit'),'403 forbidden');
        $d['title']="Edit Style Customization";
        $d['edstyle']=ProductStyleCustomization::findOrFail($id);
        return view('admin.product-setting.style-customization',$d);
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
        abort_if(Gate::denies('style_delete'), 403, "403 forbidden");
        ProductStyleCustomization::destroy($id);
        return response()->json(['msg'=>'removed successfully']);
    }
}
