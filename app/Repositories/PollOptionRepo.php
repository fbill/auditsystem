<?php
/**
 * Created by PhpStorm.
 * User: Franco
 * Date: 22/10/2018
 * Time: 05:17 PM
 */

namespace App\Repositories;

use App\Repositories\Repository;
use App\Models\PollOption;
use Illuminate\Support\Facades\DB;

class PollOptionRepo extends Repository
{

    public function getModel()
    {
        return new PollOption;
    }

    public function getOptionsForPollId($poll_id)
    {
        return PollOption::where('poll_id',$poll_id)->get();
    }

}