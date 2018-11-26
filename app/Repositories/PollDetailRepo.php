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

    public function getPollDetailsForPollId($poll_id)
    {
        $results = DB::select('select * from `poll_details` where `poll_id` = ?', [ $poll_id]);
        return $results;
    }

}