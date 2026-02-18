<?php

require_once 'ActionHandler.php';

class Dbdump extends ActionHandler {
    public function serve($payload) {
        // Process dbdump action
        $this->saveLog('dbdump', $payload);
        
        // Extract payload parameters
        $dbSource = $payload['db_source'] ?? null;
        $dbName = $payload['db_name'] ?? null;
        
        if (!$dbSource || !$dbName) {
            $this->saveLog('dbdump_error', ['error' => 'Missing db_source or db_name in payload']);
            return;
        }
        
        // Get database credentials based on source
        $dbConfig = null;
        if ($dbSource === 'production') {
            $dbConfig = $this->getConfig('db_production');
        } elseif ($dbSource === 'qa') {
            $dbConfig = $this->getConfig('db_qa');
        }
        
        if (!$dbConfig) {
            $this->saveLog('dbdump_error', ['error' => 'Invalid db_source: ' . $dbSource]);
            return;
        }
        
        // Perform database dump
        $this->performDump($dbName, $dbConfig);
    }
    
    private function performDump($dbName, $dbConfig) {
        // Get dump directory from config
        $dumpDir = $this->getConfig('dumpDir');
        if (!$dumpDir) {
            $this->saveLog('dbdump_error', ['error' => 'dumpDir not configured']);
            return;
        }
        
        if (!is_dir($dumpDir)) {
            mkdir($dumpDir, 0755, true);
        }
        
        $timestamp = date('Y-m-d_H-i-s');
        $sqlFile = $dumpDir . '/' . $dbName . '_' . $timestamp . '.sql';
        $zipFile = $dumpDir . '/' . $dbName . '_' . $timestamp . '.zip';
        
        // Build mysqldump command
        $command = sprintf(
            'mysqldump -h %s -u %s -p%s %s > %s 2>&1',
            escapeshellarg($dbConfig['db_host']),
            escapeshellarg($dbConfig['db_user']),
            escapeshellarg($dbConfig['db_password']),
            escapeshellarg($dbName),
            escapeshellarg($sqlFile)
        );
        
        // Execute mysqldump
        exec($command, $output, $returnCode);
        
        if ($returnCode === 0) {
            // Compress SQL file to ZIP
            if ($this->compressToZip($sqlFile, $zipFile)) {
                // Delete original SQL file after successful compression
                unlink($sqlFile);
                
                $this->saveLog('dbdump_success', [
                    'db_source' => $dbConfig['db_host'],
                    'db_name' => $dbName,
                    'dump_file' => $zipFile,
                    'file_size' => filesize($zipFile) . ' bytes'
                ]);
            } else {
                // Keep SQL file if compression fails
                $this->saveLog('dbdump_compression_error', [
                    'db_source' => $dbConfig['db_host'],
                    'db_name' => $dbName,
                    'sql_file' => $sqlFile,
                    'error' => 'Failed to compress SQL dump to ZIP'
                ]);
            }
        } else {
            $this->saveLog('dbdump_error', [
                'db_source' => $dbConfig['db_host'],
                'db_name' => $dbName,
                'error' => implode(' ', $output),
                'return_code' => $returnCode
            ]);
        }
    }
    
    private function compressToZip($sqlFile, $zipFile) {
        if (!file_exists($sqlFile)) {
            return false;
        }
        
        $zip = new ZipArchive();
        if ($zip->open($zipFile, ZipArchive::CREATE) !== true) {
            return false;
        }
        
        $baseName = basename($sqlFile);
        $zip->addFile($sqlFile, $baseName);
        $zip->close();
        
        return file_exists($zipFile);
    }
}

?>