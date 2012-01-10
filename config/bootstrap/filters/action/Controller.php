<?php

	// Define used classes.
	use \lithium\util\collection\Filters;

	// Get to the `Controller` instance by filtering the `Dispatcher`
	Filters::apply('\lithium\action\Dispatcher', '_callable', function($self, $params, $chain) {
		$controller = $chain->next($self, $params, $chain);

		if (is_a($controller, '\lithium\action\Controller')) {

			/**
			 * Apply the filter to our `Controller` instance. We can't apply the
			 * filter statically.
			 */
			$controller->applyFilter('__invoke', function($self, $params, $chain) {
				$profiler = \Profiler::start('action\Controller::__invoke');
				$response = $chain->next($self, $params, $chain);
				$profiler->end();

				// Return the response object.
				return $response;
			});
		}

		// Return the controller object.
		return $controller;
	});