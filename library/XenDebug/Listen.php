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

		if ( ! XenForo_Application::debugMode())
		{
			return;
		}

	 	XenDebug_Log::getInstance();
	}	

}