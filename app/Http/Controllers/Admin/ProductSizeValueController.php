<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ProductSizeValue;
use Gate;
use Illuminate\Http\Request;
use App\ProductSize;
class ProductSizeValueController extends Controller
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
        $d['size_v']=ProductSizeValue::with('getVarient')->get();
        return view('admin.product-setting.size-varient-value',$d);
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
        ProductSizeValue::updateOrCreate(['id'=>$request->id],[
            'product_size_id'=>$request->vname,
            'varient_value'=>$request->vvalue,
           ]);
           return redirect('admin/product-size-value-setting')->with("msg",'Size Varient value added successfully');
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
        $d['size_var']=ProductSizeValue::findOrFail($id);
        return view('admin.product-setting.size-varient-value',$d);
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
        ProductSizeValue::destroy($id);
        return response()->json(['msg'=>'Removed Successfully']);
    }
    public function getSizeVarient($val)
    {
      $pr=ProductSize::where('varient_category',$val)->get();
      return response()->json(['ps'=>$pr]);

    }
}
