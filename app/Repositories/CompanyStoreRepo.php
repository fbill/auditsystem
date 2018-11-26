<?php
/**
 * Created by PhpStorm.
 * User: Franco
 * Date: 22/10/2018
 * Time: 05:17 PM
 */

namespace App\Repositories;

use App\Repositories\Repository;
use App\Models\CompanyStore;
use Illuminate\Support\Facades\DB;

class CompanyStoreRepo extends Repository
{

    public function getModel()
    {
        return new CompanyStore;
    }


    public function getGraphStores($company_id)
    {
        $results = DB::select('SELECT (SELECT COUNT(company_id) FROM  `company_stores` WHERE `company_id` = ? GROUP BY company_id ) AS `base` ,
(SELECT COUNT(company_id) FROM  `company_stores` WHERE `company_id` = ? and ruteado=1 GROUP BY ruteado ) AS router', [ $company_id,$company_id]);
        return $results;
    }

    public function getUbigeosForCampaigne($company_id)
    {
        $results = DB::select('SELECT
  `stores`.`ubigeo`
FROM
  `company_stores`
  INNER JOIN `stores` ON (`company_stores`.`store_id` = `stores`.`id`)
WHERE
  `company_stores`.`company_id` = ? group by `stores`.`ubigeo`', [ $company_id]);
        return $results;
    }
}