<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;


class TicketController extends Controller
{
    public function store(Request $request)
    {
        $ticket = Ticket::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status
        ]);

        return response()->json($ticket, 201);
    }

    public function index()
    {
        $tickets = Ticket::all();
        return response()->json($tickets);
    }   
}