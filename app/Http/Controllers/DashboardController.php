<?php

namespace App\Http\Controllers;

use App\Services\FirebaseService;

class DashboardController extends Controller
{
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    public function index()
    {
        $current = [
            'cpm' => $this->firebaseService->getRadiationCpm(),
            'gauss' => $this->firebaseService->getMagneticGauss(),
            'vpm' => $this->firebaseService->getEmFieldVpm(),
        ];

        $history = $this->firebaseService->getHistory();

        return view('dashboard', compact('current', 'history'));
    }

    public function getCurrentData()
    {
        $current = [
            'current' => [
                'cpm' => $this->firebaseService->getRadiationCpm(),
                'gauss' => $this->firebaseService->getMagneticGauss(),
                'vpm' => $this->firebaseService->getEmFieldVpm(),
            ]
        ];

        return response()->json($current);
    }
}
