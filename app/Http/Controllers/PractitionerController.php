<?php

namespace App\Http\Controllers;

use App\Models\Practitioner;
use Inertia\Inertia;
use Inertia\Response;

class PractitionerController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('practitioners/Index', [
            'practitioners' => Practitioner::query()
                ->orderBy('name')
                ->get(['id', 'name']),
        ]);
    }
}
