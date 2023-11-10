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
    public function run(): void
    {
        $this->clearLogs();
        exec("php $this->processFile > $this->processLogFile &");
    }

    /** убивает процесс */
    public function kill(): void
    {
        $this->clearLogs();
        exec("pkill -f {$this->processName}");
    }

<<<<<<< HEAD
    /** очистить файлы логов.
     *
     * @param mixed $bothFiles true - оба файла
     */
    public function clearLogs($bothFiles = true): void
    {
        file_put_contents($this->pidsParseFile, '');
        if ($bothFiles) {
=======
    /** очистить логи вебсокета
     * $isAll true - все логи.
     */
    public function clearLogs($isAll = true)
    {
        file_put_contents($this->pidsParseFile, '');
        if ($isAll) {
>>>>>>> 17969649fc85ab2a2681fc6ec88c3a295f40d008
            file_put_contents($this->processLogFile, '');
        }
    }
}
