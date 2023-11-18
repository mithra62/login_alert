<?php

namespace Mithra62\LoginAlert\Services;

use ExpressionEngine\Service\Logger\File;

class LoggerService
{
    /**
     * @var File|null
     */
    protected ?File $logger = null;

    /**
     * @return File
     * @throws \Exception
     */
    public function getLogger(): File
    {
        if (is_null($this->logger)) {
            $this->logger = new File(PATH_CACHE . 'login_alert.log', ee('Filesystem'));
        }

        return $this->logger;
    }

    /**
     * @param string $level
     * @param string $message
     * @param array $context
     * @return string
     */
    public function format(string $level, string $message, array $context = []): string
    {
        $return = ' [' . date('r') . '] (' . $level . ') Message: "' . $message . '" ';
        if ($context) {
            $return .= json_encode($context);

        }

        return trim($return);
    }

    /**
     * @param string $level
     * @return bool
     */
    public function shouldLog(string $level): bool
    {
        $log_levels = ee()->config->config['login_alert_log_levels'] ?? [];
        if (!is_array($log_levels)) {
            $log_levels = [];
        }

        $log_levels = array_merge([
            'error',
            'notice',
            'warning',
            'emergency',
            'alert',
            'critical'
        ], $log_levels);

        return in_array($level, $log_levels);
    }
}