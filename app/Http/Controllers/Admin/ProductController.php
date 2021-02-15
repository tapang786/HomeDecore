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


use App\Attributes;
use App\AttributeTerms;
use App\ProductAttributes;
use DB;

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
        $d['product']=Product::orderBy('id','desc')->where('parent_id', '=', 0)->get();
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
        $d['categ']=Category::where("cid",0)->get();

        $attributes = [];
        $attribute = Attributes::orderBy('id','desc')->get();
        if(count($attribute) > 0 ) {
          //
          foreach ($attribute as $k => $v) {
            # code...
            $temp = array(
                'id' => $v->id,
                'name' => $v->name,
                'slug' => $v->slug,
            ); 
            if(count(AttributeTerms::where('attribute_id',$v->id)->orderBy('id','desc')->get()) > 0) {
              $temp['terms'] = AttributeTerms::where('attribute_id',$v->id)->orderBy('id','desc')->get();
            }
            
            array_push($attributes, $temp);
          }
          $d['attributes'] = $attributes;
        }

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
            
      $product = Product::updateOrCreate(['id'=>$request->pid], [
         'pname'=>$request->pname,
         'categories'=>$request->catry,
         'sub_category'=>($request->subcat == 0) ? '' : $request->subcat,
         'sub_sub_category'=>($request->sub_sub_category == 0)?'':$request->sub_sub_category,
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
         'tax_type'=>($request->tax=="excluded")?$request->tax_type:"",
         'tax'=>$request->tax
      ]);

      if($request->has('thumbnail')){
        if($files=$request->file('thumbnail')) {
          foreach($files as $file){
            $name=uniqid().$file->getClientOriginalName();
            $file->move('product/thumbnail', $name);
            $thumb[$i++]=$name;
          }
          $product->thumbnails=$thumb;
          $product->update();
        }
      }

      
      if($request->input('attributes')){ 
        $attributes = $request->input('attributes');
        foreach ($attributes as $key => $value) {
          # code...
          $pa = ProductAttributes::updateOrCreate(['product_id'=>$product->id, 'attribute_id' => $key], [
            'term_id'=>$value[0],
          ]);
        }
      }

      $childProducts = Product::where('parent_id', '=', $product->id)->get();
      if(count($childProducts) > 0) {
        foreach ($childProducts as $cp_k => $cp_v) {
          # code...
          $childProduct = Product::find($cp_v->id);
          $childProduct->categories = $request->catry;
          $childProduct->sub_category = $request->subcat;
          $childProduct->sub_sub_category = $request->sub_sub_category;
          $childProduct->pname=$request->pname;
          $childProduct->p_price=$request->p_price;
          $childProduct->discount=$request->discount;
          $childProduct->p_s_description=$request->p_s_description;
          $childProduct->feature=$request->feature;
          $childProduct->p_description=$request->descript;
          $childProduct->meta_title=$request->meta_title;
          $childProduct->meta_keyword=$request->meta_keyword;
          $childProduct->stock_alert=$request->stock_alert;
          $childProduct->shipping=$request->ship;
          $childProduct->return_policy=$request->return_policy;
          $childProduct->tax_type=($request->tax=="excluded")?$request->tax_type:"";
          $childProduct->tax=$request->tax;
          $childProduct->save();
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

        /*$products_variants = DB::table('products_variants')->where('parent_id','=',$id)->get();
        $variants = [];
        $variants_values = [];
        
        foreach ($products_variants as $pvk => $pv) {
          # code...
          $variant_value = json_decode($pv->variant_value, true);
          $variant_id = json_decode($pv->variant_id, true);
          //
          foreach ($variant_value as $key => $value) {
            # code...
            if (array_key_exists($key,$variants)) {
              //
              if(!in_array($value, $variants[$key])) {
                $variants[$key][] = $value;
              }
            }
            else {
              $variants[$key][] = $value;
            }
          }

          $variant_value['id'] = $pv->id;
          $variant_value['p_id'] = $pv->p_id;
          $variant_value['product'] = Product::findOrFail($pv->p_id);
          //
          array_push($variants_values, $variant_value);
        }

        $d['variants']=$variants;
        $d['variants_values']=$variants_values;*/
        
        /*return $variants;
        exit;*/
        return view('admin.product.product-details',$d);
    }

    /*public function createVarientArray($ary, $key, $value)
    {
      # code...
      //$new_ary = & $ary;
      $ary[] += $ary[$key];
      $ary = $value;

      return $ary;
      //exit;
    }*/

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('product_edit'),'403 forbidden');
        $product = Product::findOrFail($id);
        $d['product']=$product;
        $d['title']="Edit Product";
        $d['tax']=Tax::all();
        $d['categ']=Category::where("cid",0)->get();
        $d['subcats']=Category::where('cid',$product->categories)->get();
        $d['sub_sub_category']=Category::where('cid',$product->sub_category)->get();

        $attributes = [];
        $attribute = Attributes::orderBy('id','desc')->get();
        if(count($attribute) > 0 ) {
          //
          foreach ($attribute as $k => $v) {
            # code...
            $temp = array(
                'id' => $v->id,
                'name' => $v->name,
                'slug' => $v->slug,
            ); 
            if(count(AttributeTerms::where('attribute_id',$v->id)->orderBy('id','desc')->get()) > 0) {
              $temp['terms'] = AttributeTerms::where('attribute_id',$v->id)->orderBy('id','desc')->get();
            }
            
            array_push($attributes, $temp);
          }
          $d['attributes'] = $attributes;
        }

        $product_attributes=ProductAttributes::where('product_id',$id)->get();
        if(count($attribute) > 0 ) {
          $product_terms = [];
          foreach ($product_attributes as $key => $vl) {
            $temp = array(
                'product_id' => $vl->product_id,
                'attribute_id' => $vl->attribute_id,
                'term_id' => $vl->term_id,
            ); 
            //array_push($product_terms, $temp);
            $product_terms[$vl->attribute_id] = $temp;
          }

          $d['product_terms'] = $product_terms;
        }
        
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
          $html = '<option value="0">Select Category</option>';
          if(count($cat) > 0) {
            foreach ($cat as $ck => $cv) {
              # code...
              $html .= '<option value="'.$cv->id.'">'.$cv->name.'</option>';
            }
            $status = true;
          } else {
            $html = '<option value="0">Category not found</option>';
            $status = false;
          }
          
          return response()->json(['d'=>$cat, 'status' => $status, 'html'=>$html]);
        }      
    }

    public function setVarient($id,$galid=null,$type=null)
    {
      /*if($galid==null){
          session()->pull('galid');
          session()->pull('addVariantStyle');  
      }else{
          session()->put('galid',$galid);
          session()->put('addVariantStyle',$type);  
      }*/
      $d['title']=strtoupper("Set variant to product");
      $d['pid']=$id;
      //$d['color']=Color::all();
      //$d['fabric']=Fabric::all();
      $d['size'] = DB::table('variant_values')->where('variant_id', '1')->get();
      $d['color'] = DB::table('variant_values')->where('variant_id', '2')->get();
      //$d['neckline']=ProductStyleCustomization::where('style_group','Neckline')->get();
      //$d['sleeve']=ProductStyleCustomization::where('style_group','Sleeve Type')->get();
      //$d['length']=ProductStyleCustomization::where('style_group','Length')->get();
     // $d['custom']=ProductSize::where('varient_category','Custom Size')->with('getvalue')->get();
      //$d['standard']=ProductSize::where('varient_category','Standard Size')->with('getvalue')->get();

      $attributes = [];
      $attribute = Attributes::orderBy('id','desc')->get();
      foreach ($attribute as $k => $v) {
        # code...
        $temp = array(
            'id' => $v->id,
            'name' => $v->name,
            'slug' => $v->slug,
        ); 
        if(count(AttributeTerms::where('attribute_id',$v->id)->orderBy('id','desc')->get()) > 0) {
          $temp['terms'] = AttributeTerms::where('attribute_id',$v->id)->orderBy('id','desc')->get();
        }
        
        array_push($attributes, $temp);
      }
      $d['attributes'] = $attributes;

      $products_variants = DB::table('products_variants')->where('parent_id','=',$id)->get();
      $variants = [];
      $variants_values = [];
      
      foreach ($products_variants as $pvk => $pv) {
        # code...
        $variant_value = json_decode($pv->variant_value, true);
        $variant_id = json_decode($pv->variant_id, true);
        //
        foreach ($variant_value as $key => $value) {
          # code...
          if (array_key_exists($key,$variants)) {
            //
            if(!in_array($value, $variants[$key])) {
              $variants[$key][] = $value;
            }
          }
          else {
            $variants[$key][] = $value;
          }
        }

        $variant_value['id'] = $pv->id;
        $variant_value['p_id'] = $pv->p_id;
        $variant_value['product'] = Product::findOrFail($pv->p_id);
        //
        array_push($variants_values, $variant_value);
      }

      $d['variants']=$variants;
      $d['variants_values']=$variants_values;
        
      return view('admin.product.customization-setting',$d);
    }
    
    public function getStyleImage($id)
    {
      $pd=ProductStyleCustomization::findOrFail($id);
      return response()->json(['img'=>$pd]);
    }

    public function createVarient(Request $request)
    {
      # code...
      $colors = ['null'];
      if(isset($request->color)) {
        $colors = $request->color;
      }
      
      $sizes = ['null'];
      if (isset($request->size)) {
        # code...
        $sizes = $request->size;
      }

      $variants = collect($colors);
      $data = $variants->crossJoin($sizes);

      /*$type = ['A','B'];
      $data = $variants->crossJoin($sizes, $type);*/

      $variants = $data->all();
      $request->session()->put('variants', $variants);
      $html = '';
      foreach ($variants as $key => $value) {
        # code...
        $color = DB::table('variant_values')->where('id', $value[0])->first(); //Color::findOrFail($value[0]);
        $size = DB::table('variant_values')->where('id', $value[1])->first();
        $html .='<tr id="variant_row_'.($key+1).'">
                  <td>'.($key+1).'</td>
                  <td>'.$request->pid.'</td>
                  <td>'.$color->value.'</td>
                  <td>'.$size->value.'</td>
                  <td><input type="text" required name="variant_sku['.$value[0].']['.$value[1].'][]"></td>
                  <td><input type="text" required name="variant_price['.$value[0].']['.$value[1].'][]"></td>
                  <td><input type="text" required name="variant_stock['.$value[0].']['.$value[1].'][]"></td>
                  <td><input type="file" required name="variant_images['.$value[0].']['.$value[1].'][]"></td>
                  <td><button class="delete_variant far fa-trash-alt btn btn-danger btn-sm" data-row="'.($key+1).'"></button></td>
                </tr>';
      }
      return response()->json(["success"=>"created.",'variants'=>$variants, 'html' => $html], 201);
    }

    public function saveVarient(Request $request)
    {
      # code...
      $pid = $request->pid;
      
      $products = Product::where('parent_id', '=', $pid)->get();
      foreach ($products as $pk => $pv) {
        # code...
        if ($pv->id != null) {
          //
          DB::table('products_variants')->where('p_id', '=', $pv->id)->delete();
          Product::destroy($pv->id);
        }
      }

      $parent_product = Product::where('id', '=', $pid)->first();

      $variant_sku = $request->variant_sku;
      $variant_price = $request->variant_price;
      $variant_stock = $request->variant_stock;
      $parent_product_update = Product::where('id', '=', $pid)->update(array('product_type' => 'variants'));
      foreach ($variant_sku as $k => $v) {
        #code...
        foreach ($variant_sku[$k] as $key => $value) {
          # code...
          $product = Product::create([
            'pname'=>$parent_product->pname,
            'categories'=>$parent_product->categories,
            'sub_category'=>$parent_product->sub_category,
            'sub_sub_category'=>$parent_product->sub_sub_category,
            'sku_id'=>$variant_sku[$k][$key][0],
            'p_price'=>$parent_product->p_price, //$variant_price[$k][$key][0],
            's_price'=>$variant_price[$k][$key][0], //$request->s_price,
            'discount'=>$parent_product->discount,
            'p_s_description'=>$parent_product->p_s_description,
            'feature'=>$parent_product->feature,
            'p_description'=>$parent_product->p_description,
            'meta_title'=>$parent_product->meta_title,
            'meta_keyword'=>$parent_product->meta_keyword,
            'stock'=> $variant_stock[$k][$key][0],
            'stock_alert'=>$parent_product->stock_alert,
            'shipping'=>$parent_product->shipping,
            'return_policy'=>$parent_product->return_policy,
            'tax_type'=>($parent_product->tax=="excluded")?$parent_product->tax_type:"",
            'tax'=>$parent_product->tax,
            'parent_id' => $parent_product->id,
            'product_type' => 'variants',
          ]);

          $thumb=[];
          $i=0;
          if($request->has('variant_images')) {
            //
            $files=$request->file('variant_images')[$k][$key];
            if($files) {
              foreach($files as $file){
                $name=uniqid().$file->getClientOriginalName();
                $file->move('product/thumbnail', $name);
                $thumb[$i++]=$name;
              }
              $product->thumbnails=$thumb;
              $product->update();
            }
          }

          $variant = DB::table('variant_values')->select('variant_values.*', 'variant.name')->join('variant', 'variant_values.variant_id', '=', 'variant.id')->where('variant_values.id', '=', $k)->first();

          $variant_values = DB::table('variant_values')->select('variant_values.*', 'variant.name')->join('variant', 'variant_values.variant_id', '=', 'variant.id')->where('variant_values.id', '=', $key)->first();
          
          
          $variant_value = [];
          $variant_value[$variant->name] = $variant->value;
          $variant_value[$variant_values->name] = $variant_values->value;

          $variant_id = [];
          $variant_id[$variant->name] = $k;
          $variant_id[$variant_values->name] = $key;
          
          $variant_value = json_encode($variant_value);
          $variant_id = json_encode($variant_id);

          DB::table('products_variants')->insert([
            'parent_id' => $pid,
            'p_id' => $product->id,
            'variant_id' => $variant_id, //$variant->variant_id,
            'variant_value' => $variant_value, //$variant->id,
            'variant_sku' => $variant_sku[$k][$key][0],
            'variant_price' => $variant_price[$k][$key][0],
            'variant_stock' => $variant_stock[$k][$key][0],
            'variant_images' => '["'.implode(",",$thumb).'"]', //$thumb,
          ]);
        }
      }
      return redirect('admin/product/'.$pid.'#varientProd')->with('msg',"Product added successfully");
    } 

    public function deleteVarient(Request $request)
    {
      $variants = DB::table('products_variants')->where('id', '=', $request->id)->first();
      $product = Product::where('id', '=', $variants->p_id)->first(); 
      if ($variants === null) {
        return response()->json(['status' => 'false', 'message' => 'not found'], 404);
        exit;
      }  
      //$status = $product->delete();
      $status = DB::table('products_variants')->where('id', '=', $request->id)->delete();
      if($status) {
        return response()->json(['status' => $status, 'message' => 'deleted'], 200);
      } else {
        return response()->json(['status' => $status, 'message' => 'not deleted'], 200);
      }
    } 


    public function getChildCategory($cat_id)
    {
      # code...
      $category = category::where('cid','=',$cat_id)->get();
      $cats = [];
      if($categor) {
        foreach ($category as $ck => $cv) {
          # code...
          $temp = array(
              'id' => $vl->id,
              'name' => $vl->name,
              'slug' => $vl->slug,
              'status' => $vl->status,
              'parent_id' => $vl->cid,
          );
          array_push($cats, $temp);
        }
      }
      return $cats;
    }
}
