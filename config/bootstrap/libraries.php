<?php

	// Define used classes.
	use lithium\core\Libraries;

	Libraries::add(
		'PhpProfiler',
		array(
	        'prefix' => false,
	        'includePath' => dirname(dirname(__DIR__)) . '/libraries/php-profiler',
			'path' => dirname(dirname(__DIR__)) . '/libraries/php-profiler',
	        'transform' => function($class, $config) {
		        $class = explode('\\', $class);
		        $class = strtolower(array_pop($class));
		        $file = $config['path'] . '/' . $class . $config['suffix'];
	            return file_exists($file) ? $file : null;
	        }
		)
	);