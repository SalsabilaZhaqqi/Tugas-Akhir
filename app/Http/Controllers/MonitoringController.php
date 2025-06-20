<?php

namespace App\Http\Controllers;
use App\Services\FirebaseService;

use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    // Untuk mengambil dan menampilkan history ke view
    public function showHistory()
    {
        try {
            $history = $this->firebaseService->getHistory();
            
            // If request wants JSON (AJAX request), return JSON response
            if (request()->wantsJson() || request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'history' => $history ?? [],
                    'message' => empty($history) ? 'No data available' : 'Data retrieved successfully'
                ]);
            }

            // For regular requests, return the view with history data
            return view('status', ['history' => $history]);
        } catch (\Exception $e) {
            \Log::error('Error in showHistory: ' . $e->getMessage());
            
            if (request()->wantsJson() || request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to fetch history data: ' . $e->getMessage()
                ], 500);
            }

            // For regular requests, return view with error message
            return view('status')->with('error', 'Failed to fetch history data');
        }
    }

    public function storeHistory()
    {
        try {
            $data = [
                'cpm' => $this->firebaseService->getRadiationCpm(),
                'gauss' => $this->firebaseService->getMagneticGauss(),
                'vpm' => $this->firebaseService->getEmFieldVpm()
            ];

            // Validate that we have at least one valid reading
            if (!isset($data['cpm']) && !isset($data['gauss']) && !isset($data['vpm'])) {
                throw new \Exception('No valid sensor readings available');
            }

            $success = $this->firebaseService->storeToHistory($data);

            if (!$success) {
                throw new \Exception('Failed to store data in Firebase');
            }

            return response()->json([
                'success' => true,
                'message' => 'Data stored successfully',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            \Log::error('Error in storeHistory: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to store data: ' . $e->getMessage()
            ], 500);
        }
    }
}
