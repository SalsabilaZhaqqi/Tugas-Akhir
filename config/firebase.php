<?php

$projectId = env('FIREBASE_PROJECT_ID', '');

return [
    'database_url' => env('FIREBASE_DATABASE_URL', ''),
    'project_id' => $projectId,
    'credentials' => [
        'file' => env('FIREBASE_CREDENTIALS', storage_path('app/firebase/tugasakhir-6eac8-firebase-adminsdk-fbsvc-9978064b3f.json')),
    ],
];