<?php

class XenDebug_CodeEvents
{

	public static function bind($events)
	{
		$cbClass = new XenDebug_CodeEvents;

		foreach ($events AS $event)
		{
			XenForo_CodeEvent::addListener($event, array($cbClass, $event));
		}
	}

	public function __call($method, $params)
	{
		XenDebug_Log::getInstance()->logCodeEvent($method, $params);
	}

}