<?php

namespace App\Http\Controllers;

use App\Facades\Emojipedia;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $emoji = Emojipedia::random();

        return inertia('home', compact('emoji'));
    }
}
