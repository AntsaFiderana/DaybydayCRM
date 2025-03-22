<?php
namespace App\Api\v1\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\Lead;
use App\Models\Offer;
use App\Models\Project;
use App\Models\User;
use App\Services\Product\ProductService;

class DashboardApi extends Controller
{
    public function index()
    {
        $clients=Client::count();
        $users=User::count();
        $projects=Project::count();
        $leads=Lead::count();
        $offers=Offer::count();
        $invoices=Invoice::count();
        $produitsservice=new ProductService();
        return response()->json($produitsservice->getTopProductsMonthly(3));

    }
}
?>