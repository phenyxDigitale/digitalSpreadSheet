<?php

namespace phenyxDigitale\digitalSpreadSheet\Calculation\Engine;

class Logger
{
    /**
     * Flag to determine whether a debug log should be generated by the calculation engine
     *        If true, then a debug log will be generated
     *        If false, then a debug log will not be generated.
     *
     * @var bool
     */
    private $writeDebugLog = false;

    /**
     * Flag to determine whether a debug log should be echoed by the calculation engine
     *        If true, then a debug log will be echoed
     *        If false, then a debug log will not be echoed
     * A debug log can only be echoed if it is generated.
     *
     * @var bool
     */
    private $echoDebugLog = false;

    /**
     * The debug log generated by the calculation engine.
     *
     * @var string[]
     */
    private $debugLog = [];

    /**
     * The calculation engine cell reference stack.
     *
     * @var CyclicReferenceStack
     */
    private $cellStack;

    /**
     * Instantiate a Calculation engine logger.
     */
    public function __construct(CyclicReferenceStack $stack)
    {
        $this->cellStack = $stack;
    }

    /**
     * Enable/Disable Calculation engine logging.
     *
     * @param bool $writeDebugLog
     */
    public function setWriteDebugLog($writeDebugLog): void
    {
        $this->writeDebugLog = $writeDebugLog;
    }

    /**
     * Return whether calculation engine logging is enabled or disabled.
     *
     * @return bool
     */
    public function getWriteDebugLog()
    {
        return $this->writeDebugLog;
    }

    /**
     * Enable/Disable echoing of debug log information.
     *
     * @param bool $echoDebugLog
     */
    public function setEchoDebugLog($echoDebugLog): void
    {
        $this->echoDebugLog = $echoDebugLog;
    }

    /**
     * Return whether echoing of debug log information is enabled or disabled.
     *
     * @return bool
     */
    public function getEchoDebugLog()
    {
        return $this->echoDebugLog;
    }

    /**
     * Write an entry to the calculation engine debug log.
     *
     * @param mixed $args
     */
    public function writeDebugLog(string $message, ...$args): void
    {
        //    Only write the debug log if logging is enabled
        if ($this->writeDebugLog) {
            $message = sprintf($message, ...$args);
            $cellReference = implode(' -> ', $this->cellStack->showStack());
            if ($this->echoDebugLog) {
                echo $cellReference,
                ($this->cellStack->count() > 0 ? ' => ' : ''),
                $message,
                PHP_EOL;
            }
            $this->debugLog[] = $cellReference .
                ($this->cellStack->count() > 0 ? ' => ' : '') .
                $message;
        }
    }

    /**
     * Write a series of entries to the calculation engine debug log.
     *
     * @param string[] $args
     */
    public function mergeDebugLog(array $args): void
    {
        if ($this->writeDebugLog) {
            foreach ($args as $entry) {
                $this->writeDebugLog($entry);
            }
        }
    }

    /**
     * Clear the calculation engine debug log.
     */
    public function clearLog(): void
    {
        $this->debugLog = [];
    }

    /**
     * Return the calculation engine debug log.
     *
     * @return string[]
     */
    public function getLog()
    {
        return $this->debugLog;
    }
}
