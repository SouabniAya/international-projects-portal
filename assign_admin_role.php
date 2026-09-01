<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

$user = DB::table('User')->where('email', 'admin@esi.dz')->first();
if (! $user) {
    echo "USER_NOT_FOUND\n";
    exit(0);
}

echo "USER:" . json_encode($user) . PHP_EOL;

$roles = DB::table('Role')->select('roleID', 'name')->get();
echo "ROLES:" . json_encode($roles) . PHP_EOL;

$permRows = DB::table('Permission')->get();
echo "PERMISSIONS:" . json_encode($permRows) . PHP_EOL;
