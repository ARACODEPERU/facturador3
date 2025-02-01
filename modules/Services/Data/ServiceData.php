<?php

namespace Modules\Services\Data;

use GuzzleHttp\Client;

class ServiceData
{
    public static function service($type, $number)
    {
        $client = new Client(['base_uri' => config('configuration.api_service_url'), 'verify' => false]);
        $parameters = [
            'http_errors' => false,
            'connect_timeout' => 5,
            'headers' => [
                'Authorization' => 'Bearer '.config('configuration.api_service_token'),
                'Accept' => 'application/json',
            ],
        ];

        $res = $client->request('GET', '/api/'.$type.'/'.$number, $parameters);
        $response = json_decode($res->getBody()->getContents(), true);
        //dd($response);
        return $response;
    }
    public static function ruc($number){
        $client = new Client();
        $url = "http://api.sunat.binvoice.net/consulta.php";
        $form = ['form_params' => ['nruc' => $number]];

        $response = $client->request('POST', $url,$form);
        $contents = $response->getBody()->getContents();

        $obj = json_decode($contents);
        //dd($obj);
        if($obj->success){
            $result = (object) $obj->result;
            return response()->json([
                'success' => true,
                'data'=>[
                    'success' => true,
                    'name' => $result->razon_social,
                        'nombre_o_razon_social' => $result->razon_social,
                        'direccion' => $result->direccion,
                        'ubigeo' => null,
                        'estado' => $result->estado,
                        'condicion' => null
                ]
            ], 201);

        }else{
            return response()->json(['data'=>[
                'success' => false,
                'message' => 'Error de conexion a sunat'
            ]
            ], 201);
        }
    }
}
