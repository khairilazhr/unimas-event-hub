<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;


class UserEventController extends Controller
{
    public function index()
    {
        $events = Event::latest()->get(); // You can add pagination if needed
        return view('events.index', compact('events'));
    }
}
