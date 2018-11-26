<?php
/**
 * Created by PhpStorm.
 * User: Franco
 * Date: 22/10/2018
 * Time: 05:17 PM
 */

namespace App\Repositories;

use App\Repositories\Repository;
use App\Models\PollOptionDetail;
use Illuminate\Support\Facades\DB;

class PollOptionDetailRepo extends Repository
{

    public function getModel()
    {
        return new PollOptionDetail;
    }

    public function getResultForOption($poll_option_id)
    {
        $results = DB::select('select * from `poll_option_details` where `poll_option_id` = ?', [ $poll_option_id]);
        return $results;
    }

}