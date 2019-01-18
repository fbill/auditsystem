<?php
/**
 * Created by PhpStorm.
 * User: Franco
 * Date: 22/10/2018
 * Time: 05:17 PM
 */

namespace App\Repositories;

use App\Repositories\Repository;
use App\Models\StockProductPop;
use Illuminate\Support\Facades\DB;

class StockProductPopRepo extends Repository
{

    public function getModel()
    {
        return new StockProductPop;
    }

    public function getProductForPublicity($company_id,$publicity_id)
    {
        $valores = StockProductPop::where('publicity_id',$publicity_id)->where('company_id',$company_id)->where('vigente',1)->orderBy('orden','ASC')->get();
        return $valores;
    }

}