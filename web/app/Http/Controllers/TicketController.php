<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::all();
        return view('ticket', ['tickets' => $tickets]);
    }

    public function store(Request $request)
    {
        $user = $request->header('x-api-user');
        $pass = $request->header('x-api-pass');

        if (Auth::attempt(['email' => $user, 'password' => $pass])) {
            $ticket = Ticket::create([
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status
            ]);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json($ticket, 201);
    }
}