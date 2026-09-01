<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

$roleName = 'Functional Administrator';
DB::table('Role')->updateOrInsert(
    ['roleName' => $roleName],
    ['roleName' => $roleName]
);

$roleId = DB::table('Role')->where('roleName', $roleName)->value('roleID');
DB::table('AssignedRole')->updateOrInsert(
    ['userID' => 1, 'roleID' => $roleId],
    ['userID' => 1, 'roleID' => $roleId]
);

echo json_encode(DB::table('AssignedRole')->where('userID', 1)->get()) . PHP_EOL;
