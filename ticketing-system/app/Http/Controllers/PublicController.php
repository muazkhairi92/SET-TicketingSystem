<?php

namespace App\Http\Controllers;

use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    //

    public function search(Request $request){
        // dd('nlsnd');
        $request->validate([
            'user_id'=>'exists:users,id',
            'category_name'=>'string',
            'search_title'=>'string|min:3',
            'search_user_name'=>'string',
        ]);
        $collection=Ticket::query()
        ->when($request->user_id,function($que)use($request){
            $que->where('user_id',$request->user_id);
        })
        ->when($request->category_name,function($que)use($request){
            $que->whereHas('category',function($que)use($request){
                $que->where('category',$request->category_name);
            });
        })
        ->when($request->search_title,function($que)use($request){
            $que->where('title','like', "%$request->search_title%");
        })
        ->when($request->search_user_name,function($que)use($request){
            $que->whereHas('user',function($que)use($request){
                $que->where('name','like', "%$request->search_user_name%");
        });
    })->get();
    return TicketResource::collection($collection);
    
    }
}
