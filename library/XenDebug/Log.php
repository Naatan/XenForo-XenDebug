<?php

class XenDebug_Log
{

	const TYPE_DEBUG    	= 'debug';
	const TYPE_WARNING  	= 'warning';
	const TYPE_ERROR    	= 'error';
	const TYPE_EXCEPTION	= 'exception';
	const TYPE_INFO     	= 'info';
	const TYPE_REQUEST  	= 'http request';
	const TYPE_CODEEVENT	= 'code event';
	const TYPE_QUERY    	= 'sql query';

	protected static $instance = null;

	public static function getInstance()
	{
		if (self::$instance === null)
		{
			self::$instance = false;
			$class = XenForo_Application::get('options')->xenDebugLogClass;
			self::$instance = new $class;
		}

		return self::$instance;
	}

}