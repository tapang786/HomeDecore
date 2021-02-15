<?php

namespace App\Http\Controllers\Api;

use App\HomePageSetting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Http\Controllers\Api\ProductApiController;
class HomePageApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    

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
    public function getHomePageProducts()
    {
        $home=HomePageSetting::where('status',1)
             ->where('page_module','Display Products')
             ->orderBy('content_priority','asc')->get();
        $bestSeller=[];
        $latest=[];
        $i=0;$j=0;  
        //return  $home; 
         if(count($home)>0){
            foreach($home as $value){
                
                    if($value->attributes=="best seller"){
                         $product=Product::whereIn("categories",json_decode($value->product_category,true))
                                 ->orderBy('best_seller','asc')
                                 ->take($value->total_product_to_show)->get();
                         $obj=new ProductApiController();
                         $bestSeller=['title'=>$value->content_title,
                                            'description'=>$value->contents,
                                            'content_position'=>$value->content_position,
                                            'total_product_in_row'=>$value->total_product_in_row,
                                            'products'=>$obj->product($product)];   
                    }elseif ($value->attributes=="latest") {
                        $product=Product::whereIn("categories",json_decode($value->product_category,true))
                                 ->orderBy('id','desc')
                                 ->take($value->total_product_to_show)->get();
                         $obj=new ProductApiController();
                         $latest=['title'=>$value->content_title,
                                        'description'=>$value->contents,
                                        'content_position'=>$value->content_position,
                                        'total_product_in_row'=>$value->total_product_in_row,
                                        'products'=>$obj->product($product)];    
                    }
                
            }
            return response()->json(['best_seller'=>$bestSeller,'new_arrival'=>$latest],200);
         }     
    }
       public function homePageApi()
     {
        $productCollection=[]; 
        $i=0;
        $tempCollect="";
        $slider=[];$j=0;
        $post=HomePageSetting::select('content_position')->groupBy('content_position')->get();
        if(isset($post)){
            foreach($post as $postion){
                $grpBySlider=HomePageSetting::select("show_as")->groupBy("show_as")
                ->where("content_position",$postion->content_position)->get();
                if(isset($grpBySlider)){
                    foreach($grpBySlider as $grpBySlide){
                         $grpBYModule=HomePageSetting::select('page_module')
                        ->groupBy("page_module")->get();
                          
                         if(isset($grpBYModule)){
                             foreach($grpBYModule as $value){
                                //return $grpBYModule;
                                $pageModule=HomePageSetting::where('page_module',$value->page_module)
                                                           ->where('status',1)
                                                           ->orderBy('content_priority',"asc")->get();
                                if(isset($pageModule)){
                                  
                                    foreach($pageModule as $mod){
                                       
                                        if($mod->page_module=="Display Products"){
                                            if($mod->attributes=="best seller"){
                                                $product=Product::whereIn("categories",json_decode($mod->product_category,true))
                                                        ->orderBy('best_seller','asc')
                                                        ->take($mod->total_product_to_show)->get();
                                              $obj=new ProductApiController();
                                             
                                              $productCollection[$i++]=['title'=>$mod->content_title,
                                                                   'group'=>"best_seller",
                                                                   'module_type'=>"products",
                                                                   'description'=>$mod->contents,
                                                                   'content_position'=>$mod->content_position,
                                                                   'total_product_in_row'=>$mod->total_product_in_row,
                                                                   'products'=>$obj->product($product)];
                                                                 
                                              }elseif ($mod->attributes=="latest") {
                                               $product=Product::whereIn("categories",json_decode($mod->product_category,true))
                                                        ->orderBy('id','desc')
                                                        ->take($mod->total_product_to_show)->get();
                                                $obj=new ProductApiController();
                                                $productCollection[$i++]=['title'=>$mod->content_title,
                                                               'group'=>"new_arrival",
                                                               'module_type'=>"products",
                                                               'description'=>$mod->contents,
                                                               'content_position'=>$mod->content_position,                                          'total_product_in_row'=>$mod->total_product_in_row,
                                                               'products'=>$obj->product($product)]; 
                                                              
                                                 }
                                        }if($mod->page_module=="Offer Banner" || $mod->page_module=="Product Banner"){
                                        if($mod->show_as=="slider"){
                                          $slider[$j++]=array("another_filtration"=>$mod->attributes,
                                                              'pricing_type'=>$mod->pricing_type,
                                                              "min_pricing"=>$mod->min_pricing,
                                                              "max_pricing"=>$mod->max_pricing,
                                                              "banner_url"=>url('').'/'.$mod->images
                                                             );
                                             $tempCollect=[
                                                            'title'=>$mod->content_title,
                                                            'group'=>$mod->attributes,
                                                            "type"=>"slider",
                                                            'module_type'=>$mod->page_module,
                                                            'description'=>$mod->contents,
                                                            'content_position'=>$mod->content_position,            'pricing_type'=>$mod->pricing_type,
                                                            "min_pricing"=>$mod->min_pricing,
                                                            "max_pricing"=>$mod->max_pricing,
                                                            "banner_url"=>$slider];                     
                                          }elseif($mod->show_as=="single"){
                                            $productCollection[$i++]=[
                                            'title'=>$mod->content_title,
                                            'group'=>$mod->attributes,
                                            "type"=>"single",
                                            'module_type'=>$mod->page_module,
                                            'description'=>$mod->contents,
                                            'content_position'=>$mod->content_position,
                                            "another_filtration"=>$mod->attributes,
                                            'pricing_type'=>$mod->pricing_type,
                                            "min_pricing"=>$mod->min_pricing,
                                            "max_pricing"=>$mod->max_pricing,
                                            "banner_url"=>url('').'/'.$mod->images]; 
                                           
                                        }
                                      } 
                              
                                   }
                                   //return  $productCollection;      
                                }
                            
                             }
                             array_push($productCollection,$tempCollect);
                             return response()->json($productCollection,200) ;
                         }
                    }
                }
            }
           
        }else{
            return response()->json('Not Found');
        }
     }
}
