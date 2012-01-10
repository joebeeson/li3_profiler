<?php

	// Define used classes.
	use \lithium\util\collection\Filters;
	use \lithium\security\Auth;

	// Get to the `Auth` instance by filtering the `Dispatcher`
	Filters::apply('\lithium\action\Dispatcher', '_callable', function($self, $params, $chain) {
		$controller = $chain->next($self, $params, $chain);

		Auth::applyFilter('check', function($self, $params, $chain) {
			$profiler = \Profiler::start('security\Auth::check');
			$result = $chain->next($self, $params, $chain);
			$profiler->end();
			return $result;
		});

		Auth::applyFilter('set', function($self, $params, $chain) {
			$profiler = \Profiler::start('security\Auth::set');
			$result = $chain->next($self, $params, $chain);
			$profiler->end();
			return $result;
		});

		Auth::applyFilter('clear', function($self, $params, $chain) {
			$profiler = \Profiler::start('security\Auth::clear');
			$result = $chain->next($self, $params, $chain);
			$profiler->end();
			return $result;
		});

		// Return the controller object.
		return $controller;
	});