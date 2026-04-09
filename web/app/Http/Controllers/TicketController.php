<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Routing\Controller;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::all();
        return view('ticket', ['tickets' => $tickets] );
    }
}