<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateticketRequest;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $redirectTo = '/';


    function __construct()
    {
        //  $this->middleware('permission:see-all-tickets', ['only' => ['index']]);
        //  $this->middleware('permission:edit-tickets', ['only' => ['update']]);
        
    }

    public function index()
    {
        //
        
        $ticket =Auth::user()->tickets;
        // $data = Classroom::all();
        return TicketResource::collection($ticket); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if(Auth::user()->roles=='support'){
        $ticket=Auth::user()->tickets()->create($request ->all());
        return new TicketResource($ticket);
        }
        else{
            abort(403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        //
        if($ticket->user_id == Auth::id()){
            return new TicketResource($ticket);
            }
            abort(403,"unathourized user");

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateticketRequest $request, Ticket $ticket)
    {
        //
        if(Auth::user()->roles=='support'||'developer'){
            $ticket->update($request->except(["title","category"]));
            return new TicketResource($ticket);
           }
           else{
            // $class = Classroom::findOrfail($classroom);    
            abort(403);
           }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //

        if($ticket->user_id == Auth::id() && Auth::user()->roles=='support'){
            $ticket->delete();
            return response()->json(null, 204);
        }
        abort(403);
    }
}
