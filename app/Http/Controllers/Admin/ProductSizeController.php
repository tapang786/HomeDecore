<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ProductSize;
use Illuminate\Http\Request;
use Gate;
class ProductSizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('size_access'),'403 forbidden');
        $d['title']="Add Size Varient";
        $d['size_v']=ProductSize::orderBy('varient_category','desc')->get();
        return view('admin.product-setting.index',$d);
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
        ProductSize::updateOrCreate(['id'=>$request->id],[
         'varient_category'=>$request->vgroup,
         'varient_name'=>$request->vname,
        ]);
        return redirect('admin/product-size-setting')->with("msg",'Size Varient added successfully');
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
         abort_if(Gate::denies('size_access'),'403 forbidden');
        $d['title']="Edit Size Varient";
        $d['size_var']=ProductSize::findOrFail($id);
        return view('admin.product-setting.index',$d);
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
        abort_if(Gate::denies('size_delete'),'403 forbidden');
        ProductSize::destroy($id);
        return response()->json(['msg'=>'Removed Successfully']);
    }
}
