<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use Symfony\Component\HttpFoundation\Response;
use Gate;
class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $categories = [];
        $category = Category::latest()->orderBy("name","desc")->get();

        foreach ($category as $ky => $vl) {
            # code...
            $temp = array(
                'id' => $vl->id,
                'name' => $vl->name,
                'slug' => $vl->slug,
                'status' => $vl->status,
                'p_cat' => $vl->cid,
            );
            if($vl->cid != 0) {
                $sub_cat = Category::where('id', '=', $vl->cid)->first();
                if($sub_cat) {
                    $temp['p_cat_id'] = $sub_cat->id;
                    $temp['p_cat_name'] = $sub_cat->name;
                }
            }
            array_push($categories, $temp);
        }

        //$category = category::where('cid','=','0')->pluck('name','id');

        $d['cat']=$categories;
        $d['categ']=Category::orderBy("name","desc")->get();
        $d['title']='Product Categories';
        return view('admin.categories.index',$d);
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

          $categ=Category::updateOrCreate(['id'=>$request->id],[
           'name'=>$request->input('name'),
           'cid'=>$request->input('pname','No Parent')
          ]);
          //return json_encode($categ);
          return redirect('/admin/categories'); //view('admin.categories.index');
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
      abort_if(Gate::denies('category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
      $sts=Category::find($id);
      return json_encode($sts);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $sts = Category::find($request->id);
        $sts->name = $request->name;
        $sts->cid = $request->pname;
        $sts->update();
        return redirect('/admin/categories'); 
        //return view('admin.categories.index');
        //return redirect('categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        Category::destroy($id);

        $this->deleteChilds($id);
        return json_encode(['status'=> true]);
    }

    public function deleteChilds($cat_id)
    {
        # code...
        $category = Category::where('cid','=',$cat_id)->get();
        if($category) {
            foreach ($category as $sky => $svl) {
                Category::destroy($svl->id);
                $this->deleteChilds($svl->id);
            }
        }
    }
}
