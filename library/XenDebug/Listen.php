<?php

abstract class XenDebug_Listen
{

	protected static $_checked = false;

	public static function load_class_model($class, array &$extend)
	{
		if (self::$_checked)
		{
			return;
		}

		self::$_checked = true;

		if ( ! XenForo_Application::debugMode() OR (substr(PHP_SAPI, 0, 3) != 'cli' AND strpos($_SERVER['REQUEST_URI'],'admindav')))
		{
			return;
		}

	 	XenDebug_Log::getInstance();
	}	

}