<?php 
	// namespace App\core;
	use app\core\Registry;
	use app\core\AppException;
	/**
	* Router
	*/
	class Router
	{	
		private static $routers = [];

		private $basePath;

		public function __construct($basePath){
			$this->basePath = $basePath;
		}
		private function getRequestURL(){
			// $basePath = \App::getConfig()['basePath'];

			$url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] :'/';
			$url = str_replace($this->basePath, '', $url); //cat url
			$url = $url === '' || empty($url) ? '/' : $url;
			return $url;
		}

		private function getRequestMethod(){
			$method = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
			return $method;
		}

		private static function addRouter($method ,$url, $action){
			self::$routers[] = [$method,$url,$action];
		}

		public static function get($url , $action){  //App goi sang Router
			self::addRouter('GET',$url,$action);
		}

		public static function post($url , $action){  //App goi sang Router
			self::addRouter('POST',$url,$action);
		}

		public static function any($url , $action){  //App goi sang Router
			self::addRouter('GET|POST',$url,$action);
		}

		public function map(){
			$checkRoute = false;
			$params = [];

			$requestURL = $this->getRequestURL();
			$requestMethod = $this->getRequestMethod();
			
			$routers = self::$routers;

			foreach ($routers as $route) {
				list($method,$url,$action) = $route; // tach route va gan vao list method , url , action 
				
				if(strpos($method, $requestMethod) === FALSE){  //kiem tra chuoi requestMethod trong chuoi method
					continue;
				}

				if($url === '*'){
					$checkRoute = true;
				}
				elseif(strpos($url, '{') === FALSE) {
					if(strcmp(strtolower($url), strtolower($requestURL)) === 0){ // kiem tra giong nhau tuyet doi 
						// if(is_callable($action)){ // kiem tra ham nac danh closure
							$checkRoute = true;
						// }
					}else {
						continue;
					}
				} elseif(strpos($url, '}') === FALSE){
					continue;
				} else{
					$routeParams = explode('/', $url);
					$requestParams = explode('/', $requestURL);

					if( count($routeParams) !== count($requestParams)){
						continue;
					}

					foreach ($routeParams as $k => $rp) {
						if(preg_match('/^{\w+}$/', $rp)){
							$params[] = $requestParams[$k];
						}
					}
					$checkRoute = true;
				}

				if($checkRoute === true){ // kiem tra 404 notfound
					if(is_callable($action)){
						//$action(); // hien thi noi dung ham nac danh closure
						call_user_func_array($action, $params); // truyen mang $params vao ham $action
						// return;
					}
					elseif(is_string($action)){
						$this->compieRoute($action, $params);
					}
					return;
				}
				else {
					continue;
				}

			}
			return;
		}

		private function compieRoute($action ,$params){
			if(count(explode('@', $action)) !== 2){
				// die('Router error');
				throw new AppException('Router error');
			}

			$className = explode('@', $action)[0];
			$methodName = explode('@', $action)[1];

			$classNamespace = 'app\\controllers\\'.$className;
			if(class_exists($classNamespace)){
				// App::setController($className);
				Registry::getIntance()->controller = $className;
				$object = new $classNamespace;
				if(method_exists($classNamespace, $methodName)){
					// App::setAction($methodName);
					Registry::getIntance()->action = $methodName;
					call_user_func_array([$object,$methodName], $params);

				}
				else{
					// die('Method"'.$methodName.'"not found');
					throw new AppException('Method"'.$methodName.'"not found');
					
				}
			}
			else {
				// die('Class"'.$classNamespace.'"not found');
				throw new AppException('Class"'.$classNamespace.'"not found');
			}
		}

		public function run(){
			$this->map();
		}
	}
 ?>