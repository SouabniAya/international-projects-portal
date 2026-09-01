<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

$tables = ['Role', 'Permission', 'UserRole', 'UserPermission', 'RolePermission'];
foreach ($tables as $table) {
    echo "TABLE:$table\n";
    if (DB::getSchemaBuilder()->hasTable($table)) {
        foreach (DB::select('SHOW COLUMNS FROM `' . $table . '`') as $col) {
            echo $col->Field . ' -> ' . $col->Type . PHP_EOL;
        }
        $rows = DB::table($table)->limit(10)->get();
        echo 'ROWS:' . json_encode($rows) . PHP_EOL;
    } else {
        echo "MISSING\n";
    }
    echo "---\n";
}
