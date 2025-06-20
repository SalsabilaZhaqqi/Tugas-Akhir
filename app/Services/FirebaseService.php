<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Database;
use Exception;
use Illuminate\Support\Facades\Log;

class FirebaseService
{
    protected Database $database;

    public function __construct()
    {
        try {
            Log::info('Initializing Firebase Realtime Database with credentials from: ' . storage_path('app/firebase/tugasakhir-6eac8-firebase-adminsdk-fbsvc-9978064b3f.json'));

            $factory = (new Factory)
                ->withServiceAccount(storage_path('app/firebase/tugasakhir-6eac8-firebase-adminsdk-fbsvc-9978064b3f.json'))
                ->withDatabaseUri('https://tugasakhir-6eac8-default-rtdb.asia-southeast1.firebasedatabase.app');

            $this->database = $factory->createDatabase();
        } catch (Exception $e) {
            Log::error('Firebase Realtime Database connection error: ' . $e->getMessage());
            throw new Exception('Tidak dapat terhubung ke Firebase Realtime Database: ' . $e->getMessage());
        }
    }

    public function getRadiationCpm(): int
    {
        try {
            $value = $this->database->getReference('radiation/cpm')->getValue();
            Log::info('Radiation CPM value:', ['value' => $value]);
            return $value ?? 0;
        } catch (Exception $e) {
            Log::error('Error getting radiation data: ' . $e->getMessage());
            return 0;
        }
    }

    public function getMagneticGauss(): float
    {
        try {
            $value = $this->database->getReference('magnetic/gauss')->getValue();
            Log::info('Magnetic Gauss value:', ['value' => $value]);
            return $value ?? 0.0;
        } catch (Exception $e) {
            Log::error('Error getting magnetic data: ' . $e->getMessage());
            return 0.0;
        }
    }

    public function getEmFieldVpm(): float
    {
        try {
            $value = $this->database->getReference('em_field/vpm')->getValue();
            Log::info('EM Field VPM value:', ['value' => $value]);
            return $value ?? 0.0;
        } catch (Exception $e) {
            Log::error('Error getting EM field data: ' . $e->getMessage());
            return 0.0;
        }
    }

    // (Opsional) Ambil semua data sekaligus
    public function getAllData(): array
    {
        try {
            $data = [
                'cpm' => $this->getRadiationCpm(),
                'gauss' => $this->getMagneticGauss(),
                'vpm' => $this->getEmFieldVpm()
            ];
            return $data;
        } catch (Exception $e) {
            Log::error('Error getting all Firebase data: ' . $e->getMessage());
            return [];
        }
    }

    public function storeToHistory(array $data): bool
    {
        try {
            $timestamp = now()->format('Y-m-d_H:i:s');

            $this->database
                ->getReference("history/{$timestamp}")
                ->set($data);

            Log::info("History saved at {$timestamp}", $data);
            return true;
        } catch (Exception $e) {
            Log::error('Failed to store history: ' . $e->getMessage());
            return false;
        }
    }

    public function getHistory(): array
    {
        try {
            $snapshot = $this->database->getReference("history")->getValue() ?? [];
            
            // Sort by timestamp in descending order (newest first)
            krsort($snapshot);
            
            // Limit to last 50 entries
            return array_slice($snapshot, 0, 50, true);
        } catch (Exception $e) {
            Log::error('Failed to fetch history: ' . $e->getMessage());
            return [];
        }
    }


}
