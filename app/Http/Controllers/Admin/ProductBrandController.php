<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Product;
use App\ProductBrand;
use Illuminate\Http\Request;
use Gate;
use Illuminate\Support\Facades\Storage;

class ProductBrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('brand_access'),403,'Sorry, you are not allowed to access');
        $d['brand']=ProductBrand::orderBy('id','desc')->get();
        $d['title']="Add Product Brand";
        return view("admin.product-brand.index",$d);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->id==""){
            $pb=ProductBrand::firstOrNew(['name' =>  request('name')]);
            $pb->name=$request->name;
            if($request->has('icon')){
                $pb->icon=$request->file('icon')->move('brand',$request->file('icon')->getClientOriginalName());
            }
            $pb->save();
        }else{
            $pb=ProductBrand::findOrFail($request->id);
            $pb->name=$request->name;
            if($request->has('icon')){
                if(Storage::exists(url('').'/'.$pb->icon)){
                    Storage::delete(url('').'/'.$pb->icon);
                }
                $pb->icon=$request->file('icon')->move('brand',$request->file('icon')->getClientOriginalName());
            }
            $pb->update();
        }
        return redirect('admin/brand-setting')->with('msg',"Brand added or updated successfully");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('brand_edit'),403,'Sorry, you are not allowed to access');
        $d['edbrand']=ProductBrand::findOrFail($id);
        $d['title']="Edit Product Brand";
        return view("admin.product-brand.index",$d);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('brand_delete'),403,'Sorry, you are not allowed to access');
        ProductBrand::destroy($id);
        return response()->json(['msg'=>'removed successfully']);
    }
}
