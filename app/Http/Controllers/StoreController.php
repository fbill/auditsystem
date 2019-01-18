<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\StoreRepo;

class StoreController extends Controller
{
    protected $storeRepo;

    public function __construct(StoreRepo $storeRepo)
    {
        // set the model
        //$this->model = new Repository($company);
        $this->storeRepo = $storeRepo;

    }

    public function show($id)
    {
        return $this->storeRepo->show($id);
    }

    public function getMediasStore($store_ids,$company_id,$poll_id)
    {
        $values = explode('|',$store_ids);$store_values="";$c=0;
        foreach ($values as $value) {
            $c = $c +1;
            if (count($values)>$c)
            {
                $store_values .= $value .',';
            }else{
                $store_values .= $value;
            }

        }//dd($store_values);
        return $this->storeRepo->storeMediasForStoreId($company_id,$store_values,$poll_id);
    }

}
