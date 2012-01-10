<?php

	// Define used classes.
	use \lithium\util\collection\Filters;
	use \lithium\data\Connections;

	// Attach to the `Connections` adapters after dispatch.
	Filters::apply('\lithium\action\Dispatcher', '_callable', function($self, $params, $chain) {

		/**
		 * Loop over all defined `Connections` adapters and tack in our
		 * filter on the `_execute` method.
		 */
		foreach (Connections::get() as $connection) {
			$connection = Connections::get($connection);
			$connection->applyFilter('_execute', function($self, $params, $chain) {
				$profiler = \Profiler::sqlStart($params['sql']);
				$response = $chain->next($self, $params, $chain);
				$profiler->end();
				return $response;
			});
		}

		// Return the controller.
		return $chain->next($self, $params, $chain);
	});