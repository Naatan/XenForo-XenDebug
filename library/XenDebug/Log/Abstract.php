<?php

abstract class XenDebug_Log_Abstract
{

	protected $options = array();

	function __construct()
	{
		$this->options = XenForo_Application::get('options');

		$this->prepLogExceptions();
		$this->prepLogHttpRequest();
		$this->prepLogCodeEvents();
	}

	public function prepLogExceptions()
	{
		if ( ! $this->options->xenDebugLogExceptions AND
			 ! $this->options->xenDebugLogDebug)
		{
			return;
		}

		$rootDir = XenForo_Autoloader::getInstance()->getRootDir();
		$xfErrorClass = file_get_contents($rootDir . '/XenForo/Error.php');

		$xfErrorClass = str_replace('abstract class XenForo_Error', 'abstract class XenForo_Error_Abstract', $xfErrorClass);
		eval('?>' .$xfErrorClass);

		require_once $rootDir . '/XenDebug/XenForo/Error.php';
	}

	public function prepLogHttpRequest()
	{
		if ( ! $this->options->xenDebugLogHttp)
		{
			return;
		}

		$http = !empty($_SERVER['HTTPS']) ? 'HTTPS' : 'HTTP';

		$message = $this->options->xenDebugLogHttpMessage;
		$message = str_replace('{HTTPS}', $http, $message);
		$message = preg_replace_callback('/\{([a-z_]*?)\}/i', create_function('$matches','return $_SERVER[$matches[1]];'), $message);

		$this->log($message, XenDebug_Log::TYPE_REQUEST);
	}

	public function prepLogCodeEvents()
	{
		if ( ! $this->options->xenDebugLogCodeEvents)
		{
			return;
		}

		$events = $this->options->xenDebugLogCodeEventsTypes;
		$events = explode("\n", $events);
		$events = array_map('trim', $events);

		XenDebug_CodeEvents::bind($events);
	}

	public function logException(Exception $e)
	{
		if ( ! $this->options->xenDebugLogExceptions)
		{
			return;
		}

		$message = strip_tags(html_entity_decode(XenForo_Error::getExceptionTrace($e)));
		$this->log($message, XenDebug_Log::TYPE_EXCEPTION, 1);
	}

	public function logDebugMessage($message)
	{
		if ( ! $this->options->xenDebugLogDebug)
		{
			return;
		}

		$this->log($message);
	}

	public function logCodeEvent($method, $params)
	{
		$message = $method;

		$params = array_map(array($this, 'getCodeEventType'), $params);
		$message .= ' ('.implode(',',$params).')';

		$this->log($message, XenDebug_Log::TYPE_CODEEVENT);
	}

	public function logQuery($sql, $bind = array())
	{
		if ( ! $this->options->xenDebugLogSQL)
		{
			return;
		}

		$types = explode(',', $this->options->xenDebugLogSQLTypes);
		$types = array_map('trim', $types);

		if ( ! in_array('ALL',$types))
		{
			$type = strtoupper(preg_replace('/\W.*/','',trim($sql)));

			if ( ! in_array($type, $types))
			{
				return;
			}
		}

		if ( ! is_array($bind)) {
		    $bind = array($bind);
		}

		if ($sql AND count($bind) > 0)
		{
			$f = create_function('$v', 'return "\'".addslashes((string)$v)."\'";');
			$bind = array_map($f, $bind);

			$sql = str_replace('?', '%s', $sql);

			try {
				$sql = vsprintf($sql, $bind);
			} catch (Exception $e)
			{
				$sql .= "\n-- Could not parse params: " . json_encode($bind);
			}
		}

		$this->log($sql, XenDebug_Log::TYPE_QUERY);	
	}

	public function log($message, $type = XenDebug_Log::TYPE_DEBUG, $level = 3)
	{
		if ($level > $this->options->xenDebugLevel)
		{
			return;
		}

		$message = $this->formatMessage($message, $type);
		return $message;
	}

	public function formatMessage($message, $type)
	{
		if ( ! is_string($message))
		{
			$message = json_encode($message);
		}

		return date('F j H:i:s') . ':' . substr((string) microtime(true),-2) . ' - ' . strtoupper($type) . ': ' . $message;
	}

	protected function getCodeEventType($var)
	{
		if (gettype($var) == 'object' AND $class = get_class($var))
		{
			return $class;
		}

		if (in_array(gettype($var), array('boolean', 'integer', 'double', 'string', 'NULL')) AND strlen((string) $var) <= 50)
		{
			return var_export($var, true);
		}

		return gettype($var);
	}

}