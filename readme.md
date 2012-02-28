Description
===========

XenForo addon for developers that provides you with additional debugging functionality. 

Currently just adds logging functionality for Code events, SQL Queries, Exceptions, HTTP requests, Debug messages and custom logging calls.

The logging class itself is extendable so you can easily create a custom logging class that logs to a different tool (eg. syslog, firebug, another database, etc.).

Screenshots
===========

[![Debugging Configuration](http://thumbs.cl.ly/1E1p3j0b0W0n3x3t1e2B)](http://cl.ly/1E1p3j0b0W0n3x3t1e2B)
[![Debugging with ChromePHP](http://thumbs.cl.ly/272x2y0g3g210x3m223L)](http://cl.ly/272x2y0g3g210x3m223L)
[![Debugging with Terminal](http://thumbs.cl.ly/372d2M2o1p2G3D2f2n40)](http://cl.ly/372d2M2o1p2G3D2f2n40)

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