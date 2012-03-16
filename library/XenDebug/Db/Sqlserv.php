<?php

class XenDebug_Db_Sqlserv extends Zend_Db_Adapter_Sqlserv
{

	public function query($sql, $bind = array())
	{
		if (class_exists('XenDebug_Log', false) AND $instance = XenDebug_Log::getInstance())
		{
			$instance->logQuery($sql, $bind);
		}

		return parent::query($sql, $bind);
	}

}
