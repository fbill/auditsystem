<?php
/**
 * Created by PhpStorm.
 * User: Franco
 * Date: 22/10/2018
 * Time: 05:17 PM
 */

namespace App\Repositories;

use App\Repositories\Repository;
use App\Models\Poll;
use Illuminate\Support\Facades\DB;

class PollRepo extends Repository
{

    public function getModel()
    {
        return new Poll;
    }

    public function categoriesPollForCompanyAudit($company_id,$company_audit_id)
    {
        $results = DB::select('SELECT 
  `polls`.`category_id`,
  `category_products`.`fullname`
FROM
  `polls`
  LEFT OUTER JOIN `category_products` ON (`polls`.`category_id` = `category_products`.`id`)
  LEFT OUTER JOIN `company_audits` ON (`polls`.`company_audit_id` = `company_audits`.`id`)
WHERE
  `company_audits`.`company_id` = ? AND 
  `polls`.`category_id` <> 0 AND 
  `polls`.`company_audit_id` = ? group by `polls`.`category_id`,`category_products`.`fullname`', [ $company_id,$company_audit_id]);
        return $results;
    }

    public function getPollsForCategory($category_id,$company_audit_id)
    {
        return Poll::where('category_id',$category_id)->where('company_audit_id',$company_audit_id)->get();
    }

    public function getQuestionForWeb($company_id)
    {
        $polls = Poll::join('company_audits','polls.company_audit_id','=','company_audits.id')->select('polls.id','polls.question','polls.sino','polls.options','polls.identificador','polls.created_at','company_audits.company_id','polls.company_audit_id','polls.categoryProduct')->where('company_audits.company_id', $company_id)->where('polls.web', 1)->get();
        return $polls;
    }

}