<?php
/**
 * Created by PhpStorm.
 * User: Franco
 * Date: 22/10/2018
 * Time: 05:17 PM
 */

namespace App\Repositories;

use App\Repositories\Repository;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepo extends Repository
{

    public function getModel()
    {
        return new User;
    }

    public function listUserCondition($type,$customer_id="0")
    {
        if ($customer_id=="0")
        {
            $users = User::where('type', $type)->orderBy('fullname','ASC')->where('active',1)->get();
        }else{
            $sql = "SELECT 
  `users`.`id`,
  `users`.`fullname`,
  `users`.`type`,
  `users`.`email`
FROM
  `user_customers`
  INNER JOIN `customers` ON (`user_customers`.`customer_id` = `customers`.`id`)
  INNER JOIN `users` ON (`user_customers`.`user_id` = `users`.`id`)
  INNER JOIN `companies` ON (`customers`.`id` = `companies`.`customer_id`)
WHERE
  `companies`.`id` = '".$customer_id."' AND 
  `users`.`type` = '".$type."' AND `users`.`active`=1  ORDER BY  `users`.`fullname` ASC";
            $users=\DB::select($sql);
        }

        return $users;
    }

}