<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\View\View;

class ServiceController extends Controller
{
    /**
     * Page services — liste les 6 services depuis la BDD.
     */
    public function index(): View
    {
        return view('front.services', [
            'services' => Service::all(),
        ]);
    }
}
