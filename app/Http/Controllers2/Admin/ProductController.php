<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Color;
use App\Fabric;
use App\Product;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPermissionRequest;
use App\Http\Requests\MassDestroyRoleRequest;
use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\ProductSize;
use App\ProductStyleCustomization;
use App\SetProductVariant;
use App\Tax;
use App\StyleVariant;
use Facade\FlareClient\Http\Response;
use Gate;
use Illuminate\Http\Request;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('product_access'),'403 forbidden');
       session()->pull('product');
       session()->pull('clrid');
       session()->pull('colorid');
       session()->pull('setFabric');
        $d['title']="All Products";
        $d['product']=Product::orderBy('id','desc')->get();
        return view('admin.product.index',$d);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('product_create'),'403 forbidden');
        $d['title']="Add Product";
        $d['tax']=Tax::all();
        $d['categ']=Category::where("cid",'No Parent')->get();
        return view('admin.product.add-product',$d);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            $thumb=[];
            $i=0;
   
       $p=   Product::updateOrCreate(['id'=>$request->pid],[
           'pname'=>$request->pname,
           'categories'=>$request->catry,
           'sub_category'=>$request->subcat,
           'sku_id'=>$request->sku,
           'p_price'=>$request->p_price,
           's_price'=>$request->s_price,
           'discount'=>$request->discount,
           'p_s_description'=>$request->p_s_description,
           'feature'=>$request->feature,
           'p_description'=>$request->descript,
           'meta_title'=>$request->meta_title,
           'meta_keyword'=>$request->meta_keyword,
           'stock'=>$request->stock,
           'stock_alert'=>$request->stock_alert,
           'shipping'=>$request->ship,
           'return_policy'=>$request->return_policy,
           'tax_type'=>json_encode($request->tax_type),
           'tax'=>$request->tax
           ]);
            if($request->has('thumbnail')){
            if($files=$request->file('thumbnail')){
            foreach($files as $file){
            $name=uniqid().$file->getClientOriginalName();
            $file->move('product/thumbnail', $name);
            $thumb[$i++]=$name;
           }
            //  $up=Product::updateOrCreate(['id'=>$request->pid],[
            //      'thumbnails'=>json_encode($thumb)]);
            $p->thumbnails=$thumb;
            $p->update();
         }
        }
        return redirect('admin/product')->with('msg',"Product added successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $d['title']="Product Details";
        $d['product']=Product::findOrFail($id);
        $d['pVariant']=SetProductVariant::with(['colorName','getGallaryImage','getGallaryImage.getProductVariant'])
        ->where('product_id',$id)->get();
        $grpGal=StyleVariant::select("product_gallary_image_id")->groupBy("product_gallary_image_id")
        ->where('product_id',$id)->get();
        $neck=[];
        $sleeve=[];
        $length=[];
        $i=0;
        if(isset($grpGal)){
            foreach($grpGal as $gal){
              $neck[$i]=StyleVariant::with(['getStyleName','getAppliedStyleGalImage'])
              ->where('product_id',$id)
              ->where('product_gallary_image_id',$gal->product_gallary_image_id)
              ->where('style_type',"neck_style")->get();

              $sleeve[$i]=StyleVariant::with(['getStyleName','getAppliedStyleGalImage'])
              ->where('product_id',$id)->where('product_gallary_image_id',$gal->product_gallary_image_id)
              ->where('style_type',"sleeve_style")->get();

              $length[$i]=StyleVariant::with(['getStyleName','getAppliedStyleGalImage'])
              ->where('product_id',$id)->where('product_gallary_image_id',$gal->product_gallary_image_id)
              ->where('style_type',"length_style")->get();
              $i++;
            }
        }
        $d['neck']=$neck;
        $d['sleeve']=$sleeve;
        $d['length']=$length;
        return view('admin.product.product-details',$d);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('product_edit'),'403 forbidden');
        $d['product']=Product::findOrFail($id);
        $d['title']="Edit Product";
         $d['tax']=Tax::all();
        $d['categ']=Category::where("cid",'No Parent')->get();
        return view('admin.product.add-product',$d);

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
       abort_if(Gate::denies('product_delete'),'403 forbidden');
       Product::destroy($id);
       return response()->json(['msg'=>"removed successfully"]);
    }
    public function getCategory($id)
    {
     if(request()->ajax()){
          $cat=Category::where('cid',$id)->get();
          return response()->json(['d'=>$cat]);  
        }      
    }
    public function setVarient($id,$galid=null,$type=null)
    {
        if($galid==null){
            session()->pull('galid');
            session()->pull('addVariantStyle');  
        }else{
            session()->put('galid',$galid);
            session()->put('addVariantStyle',$type);  
        }
     $d['title']=strtoupper("Set  variant  to  product");
     $d['pid']=$id;
     $d['color']=Color::all();
     $d['fabric']=Fabric::all();
     $d['neckline']=ProductStyleCustomization::where('style_group','Neckline')->get();
     $d['sleeve']=ProductStyleCustomization::where('style_group','Sleeve Type')->get();
     $d['length']=ProductStyleCustomization::where('style_group','Length')->get();
     $d['custom']=ProductSize::where('varient_category','Custom Size')->with('getvalue')->get();
     $d['standard']=ProductSize::where('varient_category','Standard Size')->with('getvalue')->get();
     return view('admin.product.customization-setting',$d);
    }
    public function getStyleImage($id)
    {
      $pd=ProductStyleCustomization::findOrFail($id);
      return response()->json(['img'=>$pd]);
    }

   
}
