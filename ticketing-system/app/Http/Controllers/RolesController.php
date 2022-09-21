<?php

namespace App\Http\Controllers;

use App\Http\Resources\RolesResource;
use App\Models\Roles;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    //
    public function index()
    {
        //
        $data = Roles::all();
        // return response()->json($data); 
        return RolesResource::collection($data);
    }
}
