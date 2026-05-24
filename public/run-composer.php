<?php
ini_set('max_execution_time', 300);
$output = [];
$result = 0;
// Run composer require for spatie/laravel-translatable
exec('composer require spatie/laravel-translatable --no-interaction 2>&1', $output, $result);
echo "Result code: $result\n";
echo "Output:\n" . implode("\n", $output);
