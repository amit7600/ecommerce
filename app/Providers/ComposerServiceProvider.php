<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Model\Menu;
use App\User;
use App\Model\Roles;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('includes.sidebar', function ($view) {
            $menu = Menu::get();
            $user = User::whereId(\Auth::id())->first();
            $roles = Roles::whereId($user->role_id)->first();
            
            
            if(\Auth::user()->role_id == 1){
                $menu = Menu::whereNull('parent_id')->get();
                $child = Menu::whereNotNull('parent_id')->get();
            }else{
                if ($roles) {
                    $permissions = explode(',',$roles->permissions);
                    $menu = Menu::whereIn('id',$permissions)->whereNull('parent_id')->get();
                    $child = Menu::whereIn('id',$permissions)->whereNotNull('parent_id')->get();
                }
            }
            
            foreach ($menu as $key => $value) {
                $childMenu = [];
                foreach ($child as $keyC => $valueC) {
                    if($value->id == $valueC->parent_id) {
                        $childMenu[] = $valueC;
                    }
                }
                if (count($childMenu) > 0) {
                    $value['child'] = $childMenu;
                }
            }
            $view->with('menu',$menu);
        });
        // View::composer('includes.sidebar', function ($view) {
        //     $user = User::whereId(\Auth::id())->first();
        //     $user = explode(',',$user->permissions);
        //     $view->with('user',$user);
        // });
    }
}
