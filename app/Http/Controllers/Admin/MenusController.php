<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Menu;
use App\Menus;
class MenusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $menus = Menus::get();
        $d['title']="All Menus";
        //$d['menus']=Attributes::get();
        $attrs = [];

        foreach ($menus as $ak => $avlu) {
            # code...
            $temp = array(
                'id' => $avlu->id,
                'name' => $avlu->name,
                'slug' => $avlu->slug,
            );
            array_push($attrs, $temp);
        }

        $d['menus'] = $attrs;
        return view('admin.menu.menus',$d);
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
        $categ=Menus::updateOrCreate(['id'=>$request->id],[
           'name'=>$request->input('name'),
        ]);
        
        //return json_encode($categ);
        return redirect()->back()->with('success', 'added');
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
        $menu_type = Menus::where('id','=',$id)->pluck('slug')[0];
        Menus::destroy($id);
        $menus = Menu::where('type','=',$menu_type)->get();
        if($menus) {
            foreach ($menus as $sky => $svl) {
                Menu::destroy($svl->id);
            }
        }
        
        //$this->deleteChilds($menu_type);
        return json_encode(['status'=> true]);
    }

    /*public function deleteChilds($menu_type)
    {
        # code...
        $menu_type = Menus::where('type','=',$menu_type)->get();
        if($menu_type) {
            foreach ($menu_type as $sky => $svl) {
                Menus::destroy($svl->id);
            }
        }
    }*/
}
