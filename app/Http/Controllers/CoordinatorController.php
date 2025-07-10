<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CoordinatorController extends Controller
{
    function index ()
    {
        return view('users.coordinators');
    }
}
