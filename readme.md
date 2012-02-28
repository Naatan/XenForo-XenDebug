Installation
============

Install like any other addon. If you wish to use SQL Query Logging check the section below.

Note that this addon does nothing if you do not have debugMode turned on!

SQL Query Logging
-----------------

If you want to use the SQL logging functionality you need to add the following to the bottom of your config.php:

```php
if (file_exists(dirname(__FILE__) . '/XenDebug/Db/Mysqli.php'))
{
	$config['db']['adapterNamespace'] = 'XenDebug';
	$config['db']['adapter'] = 'Db_Mysqli';
}
```

### NOTE ###

Replace Mysqli in the above code snippet with whatever adapter you wish to use.

Currently supported adapters:

* Mysqli
* Db2
* Oracle
* Sqlserv

Configuration
=============

Configuration options are available under Options > XenDebug.

Note that the Log level for all build in log messages is 3, except for errors and exceptions, which uses log level 1.

The log level is mostly meant for custom log messages not made by this addon itself.

You'll want to pay special attention to the Logging Class setting.

Usage
=====

To log your own messages simply use the following PHP method call

```php
XenDebug_Log::getInstance()->log(MESSAGE, TYPE, LEVEL);
```

* MESSAGE - The message you wish to log (if this isn't a string it will be JSON encoded).
* TYPE - The type of message you wish to log, you can use one of the predefined constants listed below or use your own.
* LEVEL - the log level of this message.

### Message Types ###

 * XenDebug_Log::TYPE_DEBUG
 * XenDebug_Log::TYPE_WARNING
 * XenDebug_Log::TYPE_ERROR
 * XenDebug_Log::TYPE_EXCEPTION
 * XenDebug_Log::TYPE_INFO