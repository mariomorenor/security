<?php

namespace App\Http\Controllers;

use App\Models\Camera;
use App\Models\Client;
use App\Models\Responsible;
use Illuminate\Http\Request;

class ClientsController extends \TCG\Voyager\Http\Controllers\VoyagerBaseController
{
    public function getCamerasByClient(Request $request)
    {
        $cameras = Camera::where("client_id", $request->client_id)
            ->get();

        return response()->json($cameras);
    }

    public function getResponsiblesByClient(Request $request)
    {
        $responsibles = Client::find($request->client_id)->responsibles;
        
        return response()->json($responsibles);
    }
}
