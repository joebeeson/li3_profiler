<?php

	// Define used classes.
	use \lithium\util\collection\Filters;
	use \lithium\storage\Session;

	// Get to the `Session` instance by filtering the `Dispatcher`
	Filters::apply('\lithium\action\Dispatcher', '_callable', function($self, $params, $chain) {
		$controller = $chain->next($self, $params, $chain);

		Session::applyFilter('read', function($self, $params, $chain) {
			$profiler = \Profiler::start('storage\Session::read');
			$result = $chain->next($self, $params, $chain);
			$profiler->end();
			return $result;
		});

		Session::applyFilter('write', function($self, $params, $chain) {
			$profiler = \Profiler::start('storage\Session::write');
			$result = $chain->next($self, $params, $chain);
			$profiler->end();
			return $result;
		});

		// Return the controller object.
		return $controller;
	});