<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

$tables = ['Role', 'AssignedRole'];
foreach ($tables as $table) {
    echo "TABLE:$table\n";
    if (DB::getSchemaBuilder()->hasTable($table)) {
        foreach (DB::select('SHOW COLUMNS FROM `' . $table . '`') as $col) {
            echo $col->Field . ' -> ' . $col->Type . PHP_EOL;
        }
        echo 'ROWS:' . json_encode(DB::table($table)->get()) . PHP_EOL;
    } else {
        echo "MISSING\n";
    }
    echo "---\n";
}

$user = DB::table('User')->where('email', 'admin@esi.dz')->first();
if ($user) {
    echo 'TARGET_USER:' . json_encode($user) . PHP_EOL;
}
