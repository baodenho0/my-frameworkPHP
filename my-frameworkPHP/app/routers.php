<?php 
	use app\core\QueryBuilder;
	use app\core\Controller;

	Router::get('/home','HomeController@index');
	Router::get('/', function() {
	    $query = QueryBuilder::table('abc')->select('*')
	    ->orderBy('cot1','ASC')
	    ->orderBy('cot2','DESC')
	    ->limit(10)
	    ->offset(5)
	    ->get();
	    echo "<pre>";
	    print_r($query);
	});

	Router::get('/oke/men', function() {
	    echo 'oke men';
	});

	Router::any('*', function() {
	    echo '404 NOT FOUND';
	});
 ?>