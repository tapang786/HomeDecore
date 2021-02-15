<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\AttributeTerms;

class AttributesTermsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
        $categ=AttributeTerms::updateOrCreate(['id'=>$request->id],[
           'value'=>$request->input('name'),
           'attribute_id'=>$request->input('attribute_id'),
        ]);
        return json_encode($categ);
        //return redirect('/admin/attribute'); //view('admin.categories.index');
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

        $d['title']="Terms";
        $d['attribute_id']=$id;
        //$d['attributes']=Attributes::get();
        $d['terms'] = AttributeTerms::where('attribute_id',$id)->get();
        return view('admin.attribute.terms',$d);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $attr=AttributeTerms::find($id);
        return json_encode($attr);
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
        //
        AttributeTerms::destroy($id);
        //$this->deleteChilds($id);
        return json_encode(['status'=> true]);
    }
}
