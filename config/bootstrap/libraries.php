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
		        $class = strtolower(array_pop(explode('\\', $class)));
		        $file = $config['path'] . '/' . $class . $config['suffix'];
	            return file_exists($file) ? $file : null;
	        }
		)
	);