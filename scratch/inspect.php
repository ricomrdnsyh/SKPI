<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $tables = Illuminate\Support\Facades\DB::select("SHOW TABLES FROM db_skpi");
    foreach ($tables as $table) {
        $name = array_values((array)$table)[0];
        $count = Illuminate\Support\Facades\DB::table($name)->count();
        echo "Table: $name, Rows: $count\n";
    }
} catch (\Exception $e) {
    echo $e->getMessage() . "\n";
}
