<?php

	// Define used classes.
	use \lithium\core\Libraries;

	// Loop over and tack in our filters.
	$directory = __DIR__ . '/filters/';
	foreach (Libraries::get('li3_profiler', 'filters') as $filter) {
		$filter = str_replace('\\', '/', $filter) . '.php';
		if (file_exists($directory . $filter)) {
			include $directory . $filter;
		} elseif (file_exists($filter)) {
			include $filter;
		}
	}

