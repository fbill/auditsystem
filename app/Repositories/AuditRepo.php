<?php
/**
 * Created by PhpStorm.
 * User: Franco
 * Date: 22/10/2018
 * Time: 05:17 PM
 */

namespace App\Repositories;

use App\Repositories\Repository;
use App\Models\Audit;
use Illuminate\Support\Facades\DB;

class AuditRepo extends Repository
{

    public function getModel()
    {
        return new Audit;
    }

    public function getAuditsForCompanyId($company_id)
    {
        $results = DB::select('SELECT id,audit_id,(select fullname from audits where id=c.audit_id ) as nameAudit FROM company_audits c where c.audit=1 and  c.company_id=?', [ $company_id]);
        return $results;
    }


}