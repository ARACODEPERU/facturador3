<?php

namespace App\Http\Resources\Tenant;

use Illuminate\Http\Resources\Json\ResourceCollection;

class QuotationCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->collection->transform(function($row, $key) {
        
            $btn_generate = (count($row->documents) > 0 || count($row->sale_notes) > 0)?false:true;
            $btn_generate_cnt = $row->contract ?false:true;

            return [
                'id' => $row->id, 
                'soap_type_id' => $row->soap_type_id,
                'external_id' => $row->external_id,
                'date_of_issue' => $row->date_of_issue->format('Y-m-d'),
                'delivery_date' => ($row->delivery_date) ? $row->delivery_date->format('Y-m-d') : null,
                'identifier' => $row->identifier,
                'user_name' => $row->user->name,
                'customer_name' => $row->customer->name,
                'customer_number' => $row->customer->number,
                'currency_type_id' => $row->currency_type_id,
                'total_exportation' => number_format($row->total_exportation,2),
                'total_free' => number_format($row->total_free,2),
                'total_unaffected' => number_format($row->total_unaffected,2),
                'total_exonerated' => number_format($row->total_exonerated,2),
                'total_taxed' => number_format($row->total_taxed,2),
                'total_igv' => number_format($row->total_igv,2),
                'total' => number_format($row->total,2),
                'state_type_id' => $row->state_type_id, 
                'state_type_description' => $row->state_type->description, 
                'documents' => $row->documents->transform(function($row) {
                    return [
                        'number_full' => $row->number_full, 
                    ];
                }),
                'sale_notes' => $row->sale_notes->transform(function($row) {
                    return [
                        'identifier' => $row->identifier,
                    ];
                }),
                'sale_opportunity_number_full' => ($row->sale_opportunity) ? $row->sale_opportunity->number_full:null,
                'contract_number_full' => ($row->contract) ? $row->contract->number_full:null,
                'sale_opportunity' => ($row->sale_opportunity) ? $row->sale_opportunity:null,
                'btn_generate' => $btn_generate,
                'btn_generate_cnt' => $btn_generate_cnt,
                'created_at' => $row->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $row->updated_at->format('Y-m-d H:i:s'),
            ];
        });
    }
    
}
