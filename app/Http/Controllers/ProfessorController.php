<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfessorController extends Controller
{
   function index()
   {
       return view('users.professors');
   }

}
