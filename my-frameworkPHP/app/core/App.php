<?php 
	/*
	* App
	*/
	// require_once(dirname(__FILE__).'/Router.php');
	require_once(dirname(__FILE__).'/Autoload.php');

	// use app\core\Router;
	use app\core\Registry;

	class App
	{	
		private $router;
		// private static $config;
		// private static $controller;
		// private static $action;

		public function __construct($config){
			new Autoload($config['rootDir']);
			
			$this->router = new Router($config['basePath']);

			Registry::getIntance()->config = $config;
		}

		// public static function setConfig($config){
		// 	self::$config = $config;
		// }

		// public static function getConfig(){
		// 	return self::$config;
		// }

		// public static function setController($controller){
		// 	self::$controller = $controller;
		// }

		// public static function getController(){
		// 	return self::$controller;
		// }

		// public static function setAction($action){
		// 	self::$action = $action;
		// }

		// public function getAction(){
		// 	return self::$action;
		// }

		public function run(){
			$this->router->run();
		}
	}
 ?>