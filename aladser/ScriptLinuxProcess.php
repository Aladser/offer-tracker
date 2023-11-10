<?php

namespace Aladser;

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
    }

    /** проверить наличие процесса */
    public function isActive(): bool
    {
        $this->clearLogs(false);
        exec("ps aux | grep {$this->processName} > $this->pidsParseFile"); // новая таблица pidов

        return count(file($this->pidsParseFile)) > 2; // 2 строки будут всегда
    }

    /** создает процесс */
    public function run()
    {
        $this->clearLogs();
        exec("php $this->processFile > $this->processLogFile &");
    }

    /** убивает процесс */
    public function kill()
    {
        $this->clearLogs();
        exec("pkill -f {$this->processName}");
    }

    /** очистить логи вебсокета
     * $isAll true - все логи.
     */
    public function clearLogs($isAll = true)
    {
        file_put_contents($this->pidsParseFile, '');
        if ($isAll) {
            file_put_contents($this->processLogFile, '');
        }
    }
}
