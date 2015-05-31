<?php

class Request {

	private $verb;
	private $url;
	private $segments;
	private $content_type = 'text/plain';


	public function __construct($server) {

		$this->verb = strtolower($server['REQUEST_METHOD']);
		$this->url = $server['PATH_INFO'];

		$this->segments = explode('/', $this->url);
		array_shift($this->segments);

		if (isset($server['CONTENT_TYPE'])) $this->content_type = $server['CONTENT_TYPE'];

	}


	public function process($db) {

		$segments = $this->getSegments();

		$resource				= ucfirst(array_shift( $segments ));
		$controllerClassName 	= $resource . 'Controller';
		$controllerFileName 	= 'controllers/' . $controllerClassName . '.php';
		$actionMethodName 		= $this->getVerb() . $resource;
		$params 				= $segments;


		if ( ! file_exists($controllerFileName) ){

			// $error = json_encode('404: Not found.');
			// return Response::json($error, 404);
			die('404 File does not exist');

		}



		if ( $this->getVerb() != 'get' && $this->getVerb() != 'delete' ){

			if ( $this->getContentType() != 'application/json'){

				// $error = json_encode('400: Bad request.');
				// return Response::json($error, 404);
				die('404 Is not application/json');
			}

			$params = array();
			$body = file_get_contents("php://input");
			parse_str($body, $params);

		}

		require $controllerFileName;

		$params[] = $db;

		var_dump($params);

		$controller = new $controllerClassName();
		$response = call_user_func_array([$controller, $actionMethodName], $params);

		// $this->executeResponse($response);
	}


	public function getVerb (){
		return $this->verb;
	}

	public function getUrl (){
		return $this->url;
	}

	public function getSegments (){
		return $this->segments;
	}

	public function getContentType (){
		return $this->content_type;
	}

}