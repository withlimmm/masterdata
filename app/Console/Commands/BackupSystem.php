<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class BackupSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:backup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a backup of the storage/app/public folder and database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting system backup...');

        $backupDir = storage_path('app/backups');
        if (!file_exists($backupDir)) {
            mkdir($backupDir, 0755, true);
        }

        $date = now()->format('Y-m-d_H-i-s');
        $zipFileName = $backupDir . '/backup_' . $date . '.zip';

        $zip = new ZipArchive;
        if ($zip->open($zipFileName, ZipArchive::CREATE) === TRUE) {
            
            // Backup storage/app/public
            $publicPath = storage_path('app/public');
            if (file_exists($publicPath)) {
                $files = new \RecursiveIteratorIterator(
                    new \RecursiveDirectoryIterator($publicPath),
                    \RecursiveIteratorIterator::LEAVES_ONLY
                );

                foreach ($files as $name => $file) {
                    if (!$file->isDir()) {
                        $filePath = $file->getRealPath();
                        $relativePath = substr($filePath, strlen($publicPath) + 1);
                        $zip->addFile($filePath, 'public/' . $relativePath);
                    }
                }
            }

            // Simple DB Dump logic if mysqldump is available (optional)
            $dbName = env('DB_DATABASE');
            $dbUser = env('DB_USERNAME');
            $dbPass = env('DB_PASSWORD');
            $sqlFile = $backupDir . '/db_' . $date . '.sql';
            
            if ($dbName && $dbUser) {
                $passwordArg = $dbPass ? "-p\"{$dbPass}\"" : "";
                $command = "mysqldump -u {$dbUser} {$passwordArg} {$dbName} > {$sqlFile}";
                exec($command, $output, $returnVar);
                
                if ($returnVar === 0 && file_exists($sqlFile)) {
                    $zip->addFile($sqlFile, 'database.sql');
                }
            }

            $zip->close();
            
            if (file_exists($sqlFile)) {
                unlink($sqlFile); // Clean up the temp sql file
            }

            $this->info('Backup created successfully at: ' . $zipFileName);
        } else {
            $this->error('Failed to create ZIP backup.');
        }
    }
}
