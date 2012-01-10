<?php

	// Define used classes.
	use \lithium\util\collection\Filters;

	// Tack in our `Dispatcher` profiling.
	Filters::apply('\lithium\net\http\Media', 'render', function($self, $params, $chain) {
		$profiler = \Profiler::start('net\http\Media::render');
		$result = $chain->next($self, $params, $chain);
		$profiler->end();
		return $result;
	});