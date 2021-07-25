<?php

namespace App\Admin\Controllers;

use Carbon\Carbon;
use App\Models\AddCustomer;
use App\Models\AddBranch;
use App\Models\Measurement;
use App\Models\Service;
use App\Models\Tracking;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;

use Encore\Admin\Facades\Admin;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        return Admin::content(function (Content $content) {
           $content->header('Dashboard');
           $data = array();
           $current_year = date("Y");

           $data['customers'] = AddCustomer::count();
           $data['branches'] = AddBranch::count();
           $data['orders'] = Measurement::count();
           $data['trackings'] = Tracking::count();
           $data['services'] = Service::count();

           $customers = AddCustomer::select('id', 'created_at')
                ->get()
                ->groupBy(function ($val) {
                    return Carbon::parse($val->created_at)->format('M');
            });
           $orders = Measurement::select('id', 'created_at')
                ->get()
                ->groupBy(function ($val) {
                    return Carbon::parse($val->created_at)->format('M');
           });

           $month = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
           $temp = [];

           foreach ($customers as $c) {
                $temp[Carbon::parse($c[0]->created_at)->format('M')] = count($c);
           }
           $growth = [];
            foreach ($month as $m) {
                if (isset($temp[$m])) {
                    $growth[] = $temp[$m];
                } else {
                    $growth[] = 0;
                }

            }
            $temp_orders = [];
            foreach ($orders as $o) {
                $temp_orders[Carbon::parse($o[0]->created_at)->format('M')] = count($o);
            }
            $growth_orders = [];
            foreach ($month as $m) {
                if (isset($temp_orders[$m])) {
                    $growth_orders[] = $temp_orders[$m];
                } else {
                    $growth_orders[] = 0;
                }

            } 
            $data['customers_chart'] = implode(",", $growth);
            $data['orders_chart'] = implode(",", $growth_orders);

            $content->body(view('admin.dashboard', $data));

        });
       
    }
   
}
