<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function check()
    {
        return response()->json(true);
    }

}
