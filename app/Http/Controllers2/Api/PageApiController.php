<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Pages;
use Illuminate\Http\Request;

class PageApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $pg=  Pages::select('page_title')->groupBy('page_title')->get();
        $pages=[];
        $i=0;
        foreach($pg as $p){
            $pp=Pages::select('id',
            'page_sub_title as page_name',
            'page_subtitle_content as contents')->where('page_title',$p->page_title)->get();
            $pages[$i++]=array('page_group'=>$p->page_title,'page'=>$pp);
        }
        return response()->json(['pages'=>$pages],200);
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
        //
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
    }
}
