<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\HomePageSetting;
use Illuminate\Http\Request;

use App\Order;

class HomeController
{ 
    public function index()
    {
        $d['order']=Order::latest()->take(10)->get();
        return view('home', $d);
    }
    public function loadPage()
    {
        $d['banner']=HomePageSetting::orderBy('id','desc')->get();
        $d['title']="Manage Page Module";
        return view('admin.home.index',$d);
    }
    public function addModule()
    {
        $d['title']="Add Page Content Module";
        $d['category']=Category::where('cid',"No Parent")->get();
        return view('admin.home.add-module',$d);
    }

    public function editSection($id)
    {
        $d['title']="Edit Section";
        $d['category']=Category::where('cid',"No Parent")->get();
        $d['section']=HomePageSetting::where('id',$id)->first();
        return view('admin.home.add-module',$d);
    }

    public function store(Request $request)
    {
        /*$attribute=[];$i=0;
        if($request->has('bseller')){
            $attribute[$i++]=$request->bseller;
        }if($request->has('newA')){
            $attribute[$i++]=$request->newA;
        }*/
        /*echo $request->content_title; 
        exit;*/
      $hm= HomePageSetting::updateOrCreate(['id'=>$request->id],
              ['page_module'=>$request->module,
              "pricing_type"=>$request->pricingType,
              "show_as"=>$request->showas,
              "min_pricing"=>$request->minPricing,
              "max_pricing"=>$request->maxPricing,
              "product_category"=>json_encode($request->cat),
              "content_title"=>$request->content_title,
              "contents"=>$request->content,
              "attributes"=>$request->newA,
              "content_position"=>$request->content_post,
              "content_priority"=>$request->position,
              "total_product_to_show"=>$request->totproduct,
              "total_product_in_row"=>$request->productrow,
              "meta_title"=>$request->meta_title,
              "meta_description"=>$request->meta_keyword,
               ]);
               /*if($request->has('banner')){
                   $hm->images=$request->file('banner')->move('public/banner',$request->file('banner')->getClientOriginalName());
                   $hm->update();
               }*/
               return back()->with("msg","added successfully");
    }
    public function destroy($id)
    {
        if(request()->ajax()){
            HomePageSetting::destroy($id);
        }
    }
 
}
