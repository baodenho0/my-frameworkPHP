<?php 
	namespace app\controllers;
	use app\core\Controller;
	use \App;
	/**
	* HomeController
	*/
	class HomeController extends Controller
	{
		public function __construct(){
			parent::__construct();
		}

		public function index(){
			// echo $list."<br>";
			// echo $page."<br>";
			// echo 'home index';
			$this->render('index',[
				'ten'=>'tai',
				'tuoi'=>'22',
			]);
			// $this->redirect('http://google.com');\
			// echo App::getController();
			// echo App::getAction();
		}
	}

 ?>

 