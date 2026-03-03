<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$arg = $argv[1] ?? null;

if ($arg === 'all') {
    $users = User::all(['id', 'name', 'username', 'email', 'password']);
    echo $users->toJson(JSON_PRETTY_PRINT) . "\n";
    exit(0);
}

$username = $arg ?? 'nuwandi11';
$user = User::where('username', $username)->orWhere('email', $username)->first();

if (! $user) {
    echo "NOT_FOUND\n";
    exit(0);
}

echo json_encode([
    'id' => $user->id,
    'name' => $user->name,
    'username' => $user->username,
    'email' => $user->email,
    'password_hash' => $user->password,
], JSON_PRETTY_PRINT) . "\n";
