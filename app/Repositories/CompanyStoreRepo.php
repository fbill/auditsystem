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

    public function getBaseForCompanyUbigeo($company_id,$ubigeo="0")
    {
        if ($ubigeo=="0")
        {
            $results = DB::select('select (SELECT count(`company_stores`.`store_id`) FROM `company_stores`
WHERE `company_stores`.`company_id` = ?) as `base`,
(SELECT COUNT(`company_stores`.`company_id`) FROM  `company_stores`
 WHERE `company_stores`.`company_id` = ? and `company_stores`.`ruteado`=1) as `router`,
 (SELECT count(`poll_details`.`store_id`) FROM `poll_details`
where `poll_details`.`poll_id` in (select id from polls where company_audit_id in (SELECT id FROM company_audits c where company_id=?) and web=1 and identificador=\'abierto\')) as `efectivos`', [ $company_id,$company_id,$company_id]);
        }else{
            $results = DB::select('select (SELECT count(`company_stores`.`store_id`) FROM `company_stores` INNER JOIN `stores` ON (`company_stores`.`store_id` = `stores`.`id`)
WHERE `company_stores`.`company_id` = ? and `stores`.`ubigeo`=?) as `base`,
(SELECT COUNT(`company_stores`.`company_id`) FROM  `company_stores` INNER JOIN `stores` ON (`company_stores`.`store_id` = `stores`.`id`)
 WHERE `company_stores`.`company_id` = ? and `company_stores`.`ruteado`=1 and `stores`.`ubigeo`=?) as `router`,
 (SELECT count(`poll_details`.`store_id`) FROM `poll_details`  INNER JOIN `stores` ON (`poll_details`.`store_id` = `stores`.`id`)
where `poll_details`.`poll_id` in (select id from polls where company_audit_id in (SELECT id FROM company_audits c where company_id=?) and web=1 and identificador=\'abierto\')
and  `stores`.`ubigeo`=?) as `efectivos`', [ $company_id,$ubigeo,$company_id,$ubigeo,$company_id,$ubigeo]);
        }

        return $results;
    }

    public function getBaseForCompanyUbigeoAudit($company_id,$audit_id,$ubigeo="0")
    {
        switch ($company_id) {
            case 203:
                if ($audit_id==69) {$comment="and `stores`.`comment`='1'";$identificador="abierto";}
                if ($audit_id==70) {$comment="and `stores`.`comment`='1'";$identificador="abierto";}
                if ($audit_id==71) {$comment="and `stores`.`comment`='1'";$identificador="canje";}
                break;
            default:
                if ($audit_id==69) {$comment="and `stores`.`comment`='1'";$identificador="abierto";}
                if ($audit_id==71) {$comment="";$identificador="canje";}
                break;
        }
        if ($ubigeo=="0")
        {
            $results = DB::select('select (SELECT count(`company_stores`.`store_id`) FROM `company_stores` INNER JOIN `stores` ON (`company_stores`.`store_id` = `stores`.`id`)
WHERE `company_stores`.`company_id` = ? '.$comment.') as `base`,
(SELECT COUNT(`company_stores`.`company_id`) FROM  `company_stores` INNER JOIN `stores` ON (`company_stores`.`store_id` = `stores`.`id`)
 WHERE `company_stores`.`company_id` = ? and `company_stores`.`ruteado`=1  '.$comment.') as `router`,
 (SELECT count(`poll_details`.`store_id`) FROM `poll_details`  INNER JOIN `stores` ON (`poll_details`.`store_id` = `stores`.`id`)
where `poll_details`.`result`=1 and `poll_details`.`poll_id` in (select id from polls where company_audit_id in (SELECT id FROM company_audits c where company_id=?) and web=1 and identificador="'.$identificador.'")
 '.$comment.') as `efectivos`', [ $company_id,$company_id,$company_id]);
        }else{
            $results = DB::select('select (SELECT count(`company_stores`.`store_id`) FROM `company_stores` INNER JOIN `stores` ON (`company_stores`.`store_id` = `stores`.`id`)
WHERE `company_stores`.`company_id` = ? and `stores`.`ubigeo`=? '.$comment.') as `base`,
(SELECT COUNT(`company_stores`.`company_id`) FROM  `company_stores` INNER JOIN `stores` ON (`company_stores`.`store_id` = `stores`.`id`)
 WHERE `company_stores`.`company_id` = ? and `company_stores`.`ruteado`=1 and `stores`.`ubigeo`=? '.$comment.') as `router`,
 (SELECT count(`poll_details`.`store_id`) FROM `poll_details`  INNER JOIN `stores` ON (`poll_details`.`store_id` = `stores`.`id`)
where `poll_details`.`result`=1 and `poll_details`.`poll_id` in (select id from polls where company_audit_id in (SELECT id FROM company_audits c where company_id=?) and web=1 and identificador="'.$identificador.'")
and  `stores`.`ubigeo`=? '.$comment.') as `efectivos`', [ $company_id,$ubigeo,$company_id,$ubigeo,$company_id,$ubigeo]);
        }

        return $results;
    }
}