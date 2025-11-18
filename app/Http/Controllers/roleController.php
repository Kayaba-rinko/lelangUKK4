<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class roleController extends Controller
{
    public function middleware()
    {
        return [
            'auth',
        ];
    }
}
