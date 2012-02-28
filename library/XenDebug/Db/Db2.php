<?php

class XenDebug_Db_Db2 extends Zend_Db_Adapter_Db2
{

	public function query($sql, $bind = array())
	{
		if (class_exists('XenDebug_Log', false))
		{
			XenDebug_Log::getInstance()->logQuery($sql, $bind);
		}

		return parent::query($sql, $bind);
	}

}