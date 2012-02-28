<?php

class XenDebug_Log_File extends XenDebug_Log_Abstract
{

	public function log($message, $type = self::TYPE_DEBUG, $level = 3)
	{
		if ($level > $this->options->xenDebugLevel)
		{
			return;
		}

		$message = $this->formatMessage($message, $type);
		file_put_contents(sys_get_temp_dir() . '/xendebug.log', $message . "\n", FILE_APPEND);
	}

}