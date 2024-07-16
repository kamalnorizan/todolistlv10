<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyFirstController extends Controller
{
    function aboutus($namakementerian) {

        

        return view('aboutus', compact('namakementerian'));
    }
}
