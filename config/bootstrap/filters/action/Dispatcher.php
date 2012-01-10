<?php

	// Define used classes.
	use \lithium\util\collection\Filters;

	// Tack in our `Dispatcher` profiling.
	Filters::apply('\lithium\action\Dispatcher', '_callable', function($self, $params, $chain) {
		$profiler = \Profiler::start('action\Dispatcher::_callable');
		$controller = $chain->next($self, $params, $chain);
		$profiler->end();
		return $controller;
	});