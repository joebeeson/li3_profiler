<?php

	// Define used classes.
	use \lithium\core\Libraries;
	use \lithium\core\Environment;
	use \lithium\util\collection\Filters;

	// Bring in our require libraries.
	require __DIR__ . '/bootstrap/libraries.php';

	/**
	 * Library defaults. You can override any of these settings by passing
	 * in an array when adding the library via `Libraries::add`
	 *
	 * @see \lithium\core\Libraries::add()
	 */
	$options = Libraries::get('li3_profiler') + array(

		// Setting this to false will disable jQuery. A string will be the path to it.
		'jquery' => '//cdnjs.cloudflare.com/ajax/libs/jquery/1.7.1/jquery.min.js',

		// The local path to our prettify files, set to false to disable.
		'prettify' => '/li3_profiler',

		// Set which environment we should profile.
		'environment' => 'development',

		// If we should automatically inject the HTML to the view.
		'inject' => true,

		// Setup our default filters for the request.
		'filters' => array(
			'action\Dispatcher',
			'action\Controller',
			'security\Auth',
			'net\http\Media',
			'storage\Session',
			'data\Model',
		)
	);

	// Set our options and enable our `Profiler` by default.
	$options['bootstrap'] = false;
	Libraries::add('li3_profiler', $options);
	\Profiler::enable();

	// Set our jQuery options.
	if ($options['jquery']) {
		\ProfilerRenderer::setIncludeJquery(true);
		\ProfilerRenderer::setJqueryLocation($options['jquery']);
	} else {
		\ProfilerRenderer::setIncludeJquery(false);
	}

	// Set our prettify options.
	if ($options['prettify']) {
		\ProfilerRenderer::setIncludePrettify(true);
		\ProfilerRenderer::setPrettifyLocation($options['prettify']);
	} else {
		\ProfilerRenderer::setIncludePrettify(false);
	}

	/**
	 * Due to the way the `Environment` class determines the current configuration
	 * we need to wait for the `Dispatcher` to start up before we know where we are.
	 */
	Filters::apply('lithium\action\Dispatcher', '_callable', function($self, $params, $chain) {
		if (!Environment::is(Libraries::get('li3_profiler', 'environment'))) {
			// Enable the profiler.
			\Profiler::disable();
		} else {
			$controller = $chain->next($self, $params, $chain);
			if (Libraries::get('li3_profiler', 'inject')) {

				/**
				 * If we have a `Controller` object we will filter it so that we can
				 * inject our rendering HTML.
				 */
				if (is_a($controller, '\lithium\action\Controller')) {
					$controller->applyFilter('__invoke', function($self, $params, $chain) {
						$response = $chain->next($self, $params, $chain);
						if ($response->type === 'text/html') {

							/**
							 * Here we tack in our rendering if the `Response` object happens
							 * to be "text/html" and we are enabled.
							 */
							ob_start();
							\Profiler::render();
							$response->body = str_replace(
								'</body>',
								ob_get_clean() . '</body>',
								$response->body
							);
						}
						return $response;
					});
				}
			}
			return $controller;
		}
		return $chain->next($self, $params, $chain);
	});

	// Attach our separate filters to the application.
	require __DIR__ . '/bootstrap/filters.php';