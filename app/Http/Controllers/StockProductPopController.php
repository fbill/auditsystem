<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\StockProductPopRepo;

class StockProductPopController extends Controller
{
    protected $stockProductPopRepo;

    public function __construct(StockProductPopRepo $stockProductPopRepo)
    {
        // set the model
        //$this->model = new Repository($company);
        $this->stockProductPopRepo = $stockProductPopRepo;

    }

    public function show($id)
    {
        return $this->stockProductPopRepo->show($id);
    }

    public function getProductsForPublicity($company_id,$publicity_id)
    {
        $productForPublicity = $this->stockProductPopRepo->getProductForPublicity($company_id,$publicity_id);
        foreach ($productForPublicity as $item) {
            $valorFormat[] = array('stock_product_pop_id'=>$item->id,'product_id'=>$item->product_id,'product'=>$item->product->fullname);
        }
        return $valorFormat;
    }
}
