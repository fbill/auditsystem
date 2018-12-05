<?php
/**
 * Created by PhpStorm.
 * User: Franco
 * Date: 22/10/2018
 * Time: 05:17 PM
 */

namespace App\Repositories;

use App\Repositories\Repository;
use App\Models\PollDetail;
use Illuminate\Support\Facades\DB;

class PollDetailRepo extends Repository
{

    public function getModel()
    {
        return new PollDetail;
    }

    public function getPollDetailsForPollId($poll_id,$ubigeo="0")
    {
        if ($ubigeo == "0")
        {
            $results = DB::select('select * from `poll_details` where `poll_id` = ?', [ $poll_id]);
        }else{
            $results = DB::select('SELECT *
FROM
  `poll_details`
  INNER JOIN `stores` ON (`poll_details`.`store_id` = `stores`.`id`)
WHERE
  `poll_details`.`poll_id` = ? AND 
  `stores`.`ubigeo` = ? ', [ $poll_id,$ubigeo]);
        }

        return $results;
    }

}