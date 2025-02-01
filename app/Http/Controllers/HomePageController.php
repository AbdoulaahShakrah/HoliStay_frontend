<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomePageController extends Controller
{
    function index()
    {
        return view('pages.client.homepage');
    }
}
