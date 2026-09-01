<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

$tables = ['users', 'User'];
foreach ($tables as $table) {
    $exists = DB::getSchemaBuilder()->hasTable($table);
    echo "TABLE:$table EXISTS=" . ($exists ? 'yes' : 'no') . PHP_EOL;
    if ($exists) {
        $count = DB::table($table)->count();
        echo "COUNT:$count" . PHP_EOL;
        $cols = DB::select('SHOW COLUMNS FROM ' . $table);
        echo "COLUMNS:" . json_encode(array_map(fn($c) => $c->Field, $cols)) . PHP_EOL;
        $sample = DB::table($table)->limit(3)->get();
        echo "SAMPLE:" . json_encode($sample) . PHP_EOL;
    }
    echo "---" . PHP_EOL;
}
