<?php
namespace App\Http\Controllers\System;

use App\CoreFacturalo\Services\Ruc\Sunat;
use App\Http\Controllers\Controller;

class ServiceController extends Controller
{
    public function ruc($number)
    {
        $service = new Sunat();
        $res = $service->get($number);
        if ($res) {
            return [
                'success' => true,
                'data' => [
                    'name' => $res->razonSocial,
                    'trade_name' => $res->nombreComercial,
                ]
            ];
        } else {
            return [
                'success' => false,
                'message' => $service->getError()
            ];
        }
    }
    public function ruc2($number)
    {
        $client = new \GuzzleHttp\Client();
        $url = "http://api.sunat.binvoice.net/consulta.php";
        $form = ['form_params' => ['nruc' => $number]];

        $response = $client->request('POST', $url,$form);
        $contents = $response->getBody()->getContents();

        $obj = json_decode($contents);
        if($obj->success){
            $result = (object) $obj->result;
            return [
                'success' => true,
                'data' => [
                    'name' => $result->razon_social,
                    'trade_name' => $result->nombre_comercial,
                ]
            ];
        }

    }
}
