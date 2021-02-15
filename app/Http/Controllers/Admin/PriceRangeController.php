<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\PriceRange;
use Illuminate\Http\Request;
use Gate;
class PriceRangeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('prange_access'),'403 forbidden');
        $d['title']="Set price range ";
        $d['prange']=PriceRange::orderBy('id','desc')->get();
        return view('admin.price-range.index',$d);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        PriceRange::updateOrCreate(['id'=>$request->id],[
            "from"=>$request->from,
            "to"=>$request->to
        ]);
        return redirect('admin/price-range')->with('msg','price range added or updated successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('prange_edit'),'403 forbidden');
        $d['title']="Edit price range ";
        $d['edprange']=PriceRange::findOrFail($id);
        return view('admin.price-range.index',$d);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('prange_delete'),'403 forbidden');
        PriceRange::destroy($id);
        return response()->json(['msg'=>"removed successfully"]);
    }
}
