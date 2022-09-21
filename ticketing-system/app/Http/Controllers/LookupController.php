<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\PriorityLevel;
use App\Models\Status;
use Illuminate\Http\Request;

class LookupController extends Controller
{
    //
    public function __invoke()
    {
        //
        $category = Category::all()->pluck('category')->toArray();
        $priority = PriorityLevel::all()->pluck('level')->toArray();
        $status = Status::all()->pluck('status')->toArray();
        $data = [
            "Category"=>$category,
            "Priority Level"=>$priority,
            "Status" => $status];
        return response()->json($data); 
        // return RolesResource::collection($data);
    }
    // public function prioritytable()
    // {
    //     //
    //     $data = PriorityLevel::all();
    //     return response()->json($data); 
    //     // return RolesResource::collection($data);
    // }
    // public function statustable()
    // {
    //     //
    //     $data = Status::all();
    //     return response()->json($data); 
    //     // return RolesResource::collection($data);
    // }
}
