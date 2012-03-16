<?php

class XenDebug_Db_Db2 extends Zend_Db_Adapter_Db2
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
