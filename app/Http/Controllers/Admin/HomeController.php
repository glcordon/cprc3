<?php

namespace App\Http\Controllers\Admin;

use App\Client;

class HomeController
{
    public function index()
    {
        $date = \Carbon\Carbon::today()->subDays(7);
        $newThisWeek = Client::where('created_at','>=',$date)->count();

        
        return view('home', compact('newThisWeek'));
    }
}
