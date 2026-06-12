<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$users = App\Models\User::whereNotNull('avatar')->get();
echo "Total users with avatar in database: " . $users->count() . "\n\n";

$downloaded = 0;
foreach ($users as $u) {
    $raw = $u->getRawOriginal('avatar');
    echo "ID: {$u->id} | Name: {$u->name}\n";
    echo "Raw URL: " . ($raw ?? 'NULL') . "\n";
    
    $localPath = 'avatars/' . $u->id . '.svg';
    if (!\Illuminate\Support\Facades\Storage::disk('public')->exists($localPath)) {
        echo " -> Status: Not cached. Downloading now... ";
        if ($u->downloadAndCacheAvatar()) {
            echo "SUCCESS!\n";
            $downloaded++;
        } else {
            echo "FAILED!\n";
        }
    } else {
        echo " -> Status: Already cached locally.\n";
    }
    echo "--------------------------------------------------\n";
}

echo "\nSynchronization finished. {$downloaded} new avatar(s) downloaded.\n";
