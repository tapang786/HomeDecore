<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Pages;
use Illuminate\Http\Request;
use Gate;
use Symfony\Component\HttpFoundation\Response;
class PagesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('page_access'),'403 forbidden');
        $d['title']="Manage Page";
        $pg=Pages::all();
        $d['page_title']=$pg;
        $d['page']=$pg;
        return view('admin.pages.index',$d);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      abort_if(Gate::denies('page_create'),'403 forbidden');
       $d['title']="Add Page";
       return view('admin.pages.add-page',$d);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        if(request()->post())
        {
          $pg=Pages::updateOrCreate([
                'id'=>$request->pid
            ],
            [
             'page_title'=>$request->page,
             'page_sub_title'=>$request->pagename,
             'page_subtitle_content'=>$request->content,
             'meta_title'=>$request->meta_title,
             'meta_keyword'=>$request->meta_keyword,
             ]);
             if($request->has('pid')){
                 return redirect('admin/pages/');
             }else{
             session()->flash('msg',"Page added successfully");
             return back();
             }

        }

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
        abort_if(Gate::denies('page_edit'),'403 forbidden');
        $title="Edit Page";
        $p=Pages::findOrFail($id);
        return view('admin.pages.add-page',['page'=>$p,'title'=>$title]);
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
        abort_if(Gate::denies('page_delete'),'403 forbidden');
        if(request()->ajax()){
          $pg=Pages::findOrFail($id);
          $pg->delete();
          return response()->json(['msg'=>'Removed successfully']);
        }
    }
}
