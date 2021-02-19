<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Menu;
use App\Menus;
use Symfony\Component\HttpFoundation\Response;
use Gate;
class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if ($request->input('menu')) {
        	# code...
        	$menu_type = $request->input('menu');
        	$menu = Menu::where('type','=', $menu_type)->orderBy("name","desc")->get();
        } else {
        	$menu_type = Menus::latest()->pluck('slug')[0];
        	$menu = Menu::where('type','=', $menu_type)->orderBy("name","desc")->get();
        }
        
        $menus = [];

        foreach ($menu as $ky => $vl) {
            # code...
            $temp = array(
                'id' => $vl->id,
                'name' => $vl->name,
                'slug' => $vl->slug,
                'url' => $vl->url,
                //'parent_menu' => $vl->parent_menu,
            );
            if($vl->parent_menu != 0) {
                $sub_cat = Menu::where('id', '=', $vl->parent_menu)->first();
                if($sub_cat) {
                    $temp['parent_menu'] = $sub_cat->id;
                    $temp['parent_menu_name'] = $sub_cat->name;
                }
            }
            if($vl->parent_menu == 0) {
            	$temp['sub_menu'] = [];
                $sub_menu = Menu::where('parent_menu', '=', $vl->id)->get();
                if(count($sub_menu) > 0){
                	foreach ($sub_menu as $sky => $svl) {
                		$sub_temp = array(
			                'id' => $svl->id,
			                'name' => $svl->name,
			                'slug' => $svl->slug,
			                'url' => $svl->url,
			                'parent_menu' => $vl->id,
			                'parent_menu_name' => $vl->name,
			            );
			            array_push($temp['sub_menu'], $temp);
                	}
                }
            }
            array_push($menus, $temp);
        }

        //$category = category::where('cid','=','0')->pluck('name','id');
        $main_menu = Menus::latest()->orderBy("name","desc")->get();
        $d['main_menu'] = Menus::latest()->orderBy("name","desc")->get(); //(count($main_menu) > 0 ) ? $main_menu : 0 ;
        $d['menus']=$menus;
        $d['menu_type']=$menu_type;
       	$d['parrent_menu']=Menu::where('type','=', $menu_type)->orderBy("name","desc")->get();
        $d['title']='Menus';
        return view('admin.menu.index',$d);
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
        $categ=Menu::updateOrCreate(['id'=>$request->id],[
           'name'=>$request->input('name'),
           'url'=>$request->input('url'),
           'parent_menu'=>$request->input('pname','No Parent'),
           'type'=>$request->input('menu_type'),
        ]);
          //return json_encode($categ);
         return redirect()->back()->with('success', 'added'); //return redirect('/admin/menu');
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
        //abort_if(Gate::denies('category_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
      	$sts=Menu::find($id);
      	return json_encode($sts);
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
        $sts = Menu::find($request->id);
        $sts->name = $request->name;
        $sts->parent_menu = $request->parent_menu;
        $sts->update();
        return redirect('/admin/menu');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //abort_if(Gate::denies('category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        Menu::destroy($id);

        $this->deleteChilds($id);
        return json_encode(['status'=> true]);
    }

    public function deleteChilds($cat_id)
    {
        # code...
        $category = Menu::where('parent_menu','=',$cat_id)->get();
        if($category) {
            foreach ($category as $sky => $svl) {
                Menu::destroy($svl->id);
                $this->deleteChilds($svl->id);
            }
        }
    }
}
