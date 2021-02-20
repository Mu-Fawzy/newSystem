<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Subcontractor;
use App\Models\Workitem;
use App\Models\Worksite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $allcontracts = new Contract;
        $contracts = $allcontracts->select(
            DB::raw('YEAR(created_at) as year'),
            DB::raw('COUNT(DISTINCT(contract_number)) as contNum'),
            DB::raw('COUNT(DISTINCT(worksite_id)) as siteNum'),
            DB::raw('COUNT(DISTINCT(workitem_id)) as workNum'),
            DB::raw('COUNT(DISTINCT(subcontractor_id)) as subNum'),
        )
        ->groupBy('year')->get();

        $array = [];
        $array['years'] = $contracts->pluck('year')->toArray();
        $array['contracts'] = $contracts->pluck('contNum')->toArray();
        $array['sites'] =  $contracts->pluck('siteNum')->toArray();
        $array['items'] =  $contracts->pluck('workNum')->toArray();
        $array['subcontractors'] =  $contracts->pluck('subNum')->toArray();

        $array['countContract'] =  $allcontracts->count();
        $array['subcontractor'] =  Subcontractor::count();
        $array['workitem'] =  Workitem::count();
        $array['worksite'] =  Worksite::count();

        return view( 'dashboard.index', $array);
    }
}
