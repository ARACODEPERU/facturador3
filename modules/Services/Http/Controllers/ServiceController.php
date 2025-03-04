<?php

namespace Modules\Services\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Services\Data\ServiceData;

class ServiceController extends Controller
{
    public function service($type, $number)
    {
        //dd('ddd');
        if($type == 'ruc'){
            return ServiceData::ruc($number);
        }else if($type == 'dni'){
            return ServiceData::service($type, $number);
        }

    }

}
