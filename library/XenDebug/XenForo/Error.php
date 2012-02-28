<?php

abstract class XenForo_Error extends XenForo_Error_Abstract
{

	public static function unexpectedException(Exception $e)
	{
		if ($log = XenDebug_Log::getInstance())
		{
			$log->logException($e);
		}

		return parent::unexpectedException($e);
	}

	public static function logException(Exception $e, $rollbackTransactions = true)
	{
		if ($log = XenDebug_Log::getInstance())
		{
			$log->logException($e);
		}

		return parent::logException($e, $rollbackTransactions);
	}

	public static function debug($message)
	{
		if ($log = XenDebug_Log::getInstance())
		{
			$log->logDebugMessage($message);
		}

		parent::debug($message);
	}

}