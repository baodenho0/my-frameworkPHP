<?php 
	require_once(dirname(__DIR__).'/app/core/App.php');
	$config = require_once(dirname(__DIR__).'/config/main.php');
	// echo '<pre>';print_r($config);

	// App::setConfig($config);
	// echo '<pre>';print_r(App::getConfig());
	$app = new App($config);
	$app->run();
?>