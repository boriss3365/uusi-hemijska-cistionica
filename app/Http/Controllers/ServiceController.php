<?php

namespace App\Http\Controllers;

use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::query()->orderBy('name')->get();

        return view('services.index', compact('services'));
    }
}
