<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getMenus($audits)
    {
        $menus[] = array('name'=>'Panel de Control','url'=>'/panel','icon'=>'icon-speedometer');
        $menus[] = array('title'=>true,'name'=>'Auditorias');
        foreach ($audits as $audit) {
            $menus[] = array('id'=>$audit->id,'name'=>$audit->audit,'url'=>'/panel','icon'=>'icon-speedometer');
        }
        return $menus;
    }
}
