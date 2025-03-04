<?php

namespace Modules\Inventory\Http\Controllers;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use App\Models\Tenant\Establishment;
use App\Models\Tenant\Company;
use App\Models\Tenant\Item;
use Modules\Inventory\Models\ItemWarehouse;
use Modules\Inventory\Exports\InventoryExport;
use Modules\Inventory\Models\Warehouse;



use Carbon\Carbon;

class ReportInventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {


        if($request->warehouse_id && $request->warehouse_id != 'all')
        {
            $reports = ItemWarehouse::with(['item'])->where('warehouse_id', $request->warehouse_id)->whereHas('item',function($q){
                $q->where([['item_type_id', '01'], ['unit_type_id', '!=','ZZ']]);
                $q->whereNotIsSet();
            })->latest()->paginate(config('tenant.items_per_page'));
        }
        else{

            $reports = ItemWarehouse::with(['item'])->whereHas('item',function($q){
                $q->where([['item_type_id', '01'], ['unit_type_id', '!=','ZZ']]);
                $q->whereNotIsSet();
            })->latest()->paginate(config('tenant.items_per_page'));
        }


        $warehouses = Warehouse::select('id', 'description')->get();

        return view('inventory::reports.inventory.index', compact('reports', 'warehouses'));
    }

    /**
     * Search
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request) {

        $reports = ItemWarehouse::with(['item'])->whereHas('item', function($q){
            $q->where([['item_type_id', '01'], ['unit_type_id', '!=','ZZ']]);
            $q->whereNotIsSet();
        })->latest()->get();

        return view('inventory::reports.inventory.index', compact('reports'));
    }

    /**
     * PDF
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function pdf(Request $request) {
        ini_set('memory_limit', '2048M');
        $company = Company::first();
        $establishment = Establishment::first();
        ini_set('max_execution_time', 0);

        if($request->warehouse_id && $request->warehouse_id != 'all')
        {
            $reports = ItemWarehouse::with(['item'])->where('warehouse_id', $request->warehouse_id)->whereHas('item', function($q){
                $q->where([['item_type_id', '01'], ['unit_type_id', '!=','ZZ']]);
                $q->whereNotIsSet();
            })->latest()->get();
        }
        else{

            $reports = ItemWarehouse::with(['item'])->whereHas('item', function($q){
                $q->where([['item_type_id', '01'], ['unit_type_id', '!=','ZZ']]);
                $q->whereNotIsSet();
            })->latest()->get();
        }



        $pdf = PDF::loadView('inventory::reports.inventory.report_pdf', compact("reports", "company", "establishment"));
        $filename = 'Reporte_Inventario'.date('YmdHis');

        return $pdf->download($filename.'.pdf');
    }

    /**
     * Excel
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function excel(Request $request) {
        ini_set('memory_limit', '2048M');
        $company = Company::first();
        $establishment = Establishment::first();


        if($request->warehouse_id && $request->warehouse_id != 'all')
        {
            $records = ItemWarehouse::with(['item'])->where('warehouse_id', $request->warehouse_id)->whereHas('item', function($q){
                $q->where([['item_type_id', '01'], ['unit_type_id', '!=','ZZ']]);
                $q->whereNotIsSet();
            })->latest()->get();

        }
        else{
            $records = ItemWarehouse::with(['item'])->whereHas('item', function($q){
                $q->where([['item_type_id', '01'], ['unit_type_id', '!=','ZZ']]);
                $q->whereNotIsSet();
            })->latest()->get();

        }


        return (new InventoryExport)
            ->records($records)
            ->company($company)
            ->establishment($establishment)
            ->download('ReporteInv'.Carbon::now().'.xlsx');
    }
}
