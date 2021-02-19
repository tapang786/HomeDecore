<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use App\Setting;
use App\Menu;
use App\Menus;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        //$
        $setting = Setting::first(); // Get the last 10 registered users
        
        $menus_types = Menus::get();
        $attrs = [];
        foreach ($menus_types as $ak => $avlu) {
            # code...
            $temp = array(
                'id' => $avlu->id,
                'name' => $avlu->name,
                'slug' => $avlu->slug,
            );

            $menus = Menu::where('type','=', $avlu->slug)->orderBy("id","ASC")->get();
            $menu = [];
            foreach ($menus as $ky => $vl) {
                # code...
                //echo $ky;
                $temp_menu = array(
                    'id' => $vl->id,
                    'name' => $vl->name,
                    'slug' => $vl->slug,
                    'url' => $vl->url,
                    //'parent_menu' => $vl->parent_menu,
                );
                
                if($vl->parent_menu == 0) {
                    $temp_menu['sub_menu'] = [];
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
                            array_push($temp_menu['sub_menu'], $sub_temp);
                        }
                    }
                }
                array_push($menu, $temp_menu);
            }
            $temp['menus'] = $menu;
            //array_push($attrs, $temp);
            $attrs[$avlu->slug] = $temp;
        }

        $data = array(
            'setting' => $setting,
            'menus' => $attrs,
        );
        //exit;
        view()->share('data', $data); // Pass the $users variable to all views
    }
}
