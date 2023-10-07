<?php

namespace App;

/** PHP-скрипт как Linux процесс */
class ScriptLinuxProcess
{
    /** имя процесса */
    private string $processName;
    /** путь скрипта */
    private string $processFile;
    /** путь к логам процесса */
    private string $processLogFile;
    /** путь к файлу парсинга процессов Linux */
    private string $pidsParseFile;
    /** PID процесса */
    private $PID;

    public function __construct(
        string $processName,
        string $scriptFilepath,
        string $processLogFilepath,
        string $pidParseFilepath
    ) {
        $this->processName = $processName;
        $this->processFile = $scriptFilepath;
        $this->processLogFile = $processLogFilepath;
        $this->pidsParseFile = $pidParseFilepath;
        $this->PID = $this->findPID();
    }

    /** проверить наличие процесса */
    public function isActive(): bool
    {
        file_put_contents($this->pidsParseFile, '');
        exec("ps aux | grep {$this->processName} > $this->pidsParseFile"); // новая таблица pidов 
        return count(file($this->pidsParseFile)) > 2; // 2 строки будут всегда
    }

    /** создает процесс */
    public function run()
    {
        $this->clearLogs();
        exec("php $this->processFile > $this->processLogFile &");
        $this->PID = $this->findPID();
    }

    /** убивает процесс */
    public function disable()
    {
        exec("kill {$this->PID}");
    }

    /** поиск PID */
    private function findPID()
    {
        $pidsArr = file($this->pidsParseFile);
        for ($i=0; $i<count($pidsArr); $i++) {
            if (mb_stripos($pidsArr[$i], "php {$this->processFile}" != -1)) {
                $processArr = explode('    ', $pidsArr[$i]);
                $processArr = $processArr[2];
                $processArr = explode(' ', $processArr);
                return $processArr[0];
            }
        }
        return -1;
    }

    public function getPID()
    {
        return $this->PID;
    }

    /** очистить логи вебсокета */
    public function clearLogs()
    {
        file_put_contents($this->processLogFile, '');
        file_put_contents($this->pidsParseFile, '');
    }
}
