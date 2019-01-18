<?php
/**
 * Created by PhpStorm.
 * User: Franco
 * Date: 22/10/2018
 * Time: 05:17 PM
 */

namespace App\Repositories;

use App\Repositories\Repository;
use App\Models\Store;
use Illuminate\Support\Facades\DB;

class StoreRepo extends Repository
{

    public function getModel()
    {
        return new Store;
    }

    public function storeMediasForStoreId($company_id,$store_id,$poll_id)
    {
        /*$sql = 'SELECT
  s.id,
  s.fullname,
  s.address,
  s.ubigeo,
  m.archivo
FROM
  medias m
  RIGHT OUTER JOIN stores s ON (m.store_id = s.id)
WHERE
  m.store_id IN ('.$store_id.') AND 
  m.company_id = '.$company_id.' AND 
  m.poll_id = '.$poll_id.'
GROUP BY
  s.id,
  s.fullname,
  s.address,
  s.ubigeo,
  m.archivo';*/
        $sql = 'SELECT
  `s`.`id`,
  `s`.`fullname`,
  `s`.`address`,
  `s`.`district`,
  `s`.`region`,
  `s`.`ubigeo`,
  (case when  `m`.`archivo` is null then ""  else `m`.`archivo` end) as `archivo`,`p`.`comentario`
FROM
  `poll_details` `p`
  LEFT OUTER JOIN (
  SELECT 
  `me`.`archivo`,
  `me`.`store_id`
FROM
  `medias` `me`
WHERE
  `me`.`company_id` = '.$company_id.' AND 
  `me`.`poll_id` = '.$poll_id.'
GROUP BY
  `me`.`store_id`
  ) `m` ON (`p`.`store_id` = `m`.`store_id`)
  LEFT OUTER JOIN `stores` `s` ON (`p`.`store_id` = `s`.`id`)
WHERE
  `p`.`store_id` IN ('.$store_id.') AND 
  `p`.`poll_id` = '.$poll_id.' AND
  `p`.`company_id` = '.$company_id.'
GROUP BY
  s.id,
  s.fullname,
  s.address,`s`.`region`,
  s.ubigeo,`m`.`archivo`';

        // dd($sql);
        $results = DB::select($sql);
        return $results;
    }

}