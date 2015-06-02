<?php

class Request {

	private $verb;
	private $url;
	private $segments;
	private $content_type = 'text/plain';
	private $resource;
	private $controllerClassName;
	private $controllerFileName;
	private $actionMethodName;
	private $modelFileName;
	private $bodyParams = NULL;


	public function __construct($server) {

		$this->verb = strtolower($server['REQUEST_METHOD']);
		$this->url = $server['PATH_INFO'];

		$this->segments = explode('/', $this->url);
		array_shift($this->segments);

		if ( isset($server['CONTENT_TYPE']) ) 
			$this->content_type = $server['CONTENT_TYPE'];

		$this->resource = ucfirst(array_shift( $this->segments ));
		$this->controllerClassName = $this->resource . 'Controller';
		$this->controllerFileName = 'controllers/' . $this->controllerClassName . '.php';
		$this->actionMethodName = $this->verb . $this->resource;
		$this->modelFileName = 'models/' . $this->resource . '.php';

		if ( $this->verb == 'put' || $this->verb == 'post' )
				$this->bodyParams = $this->parseBodyParams();

	}

	public function parseBodyParams() {

			if ( $this->getContentType() != 'application/json'){

				die('404 Is not application/json');
			}

			$bodyParams = array();
			$body = file_get_contents("php://input");

			if ( ! Validation::isJson($body) )
				die("400 Bad request;");

			$bodyParams = json_decode($body, true);

			return $bodyParams;

	}


	public function process($db) {

		$verb 					= $this->getVerb();
		$resource				= $this->getResource();
		$controllerClassName 	= $this->getControllerClassName();
		$controllerFileName 	= $this->getControllerFileName();
		$actionMethodName 		= $this->getActionMethodName();
		$modelFileName			= $this->getModelFileName();
		$bodyParams				= $this->getBodyParams();

		$params 				= $this->getSegments();
		$id 					= $this->getId($params);


		if ( ! file_exists($controllerFileName) ){

			// $error = json_encode('404: Not found.');
			// return Response::json($error, 404);
			die('404 File does not exist');

		}

		// $this->takeRequestBody();



		if ( $verb == 'get' || $verb == 'delete') {

			$function_params = [$db, $id];

		} elseif ($verb == 'put') {

			$function_params = [$db, $id, $bodyParams];

		} else if ($verb == 'post') {

			$function_params = [$db, $bodyParams];

		} else {

			die('400 Bad requests');
		}

		require $modelFileName;
		require $controllerFileName;

		$controller = new $controllerClassName();
		$response = call_user_func_array([$controller, $actionMethodName], $function_params);

		$this->execute($response);
	}


	private function execute($response = NULL){

		if (is_string($response)) {

			echo $response;

		} elseif (is_array($response)){

			echo json_encode($response);

		}else {

			die("500: Invalid response: TYPE IS:" .  print_r($response));

		}
	}


	private function getId($params){

		return array_shift($params);
	}















	public function getModelFileName() {
		return $this->modelFileName;
	}

	public function getVerb() {
		return $this->verb;
	}

	public function getUrl() {
		return $this->url;
	}

	public function getSegments() {
		return $this->segments;
	}

	public function getContentType() {
		return $this->content_type;
	}

	public function getResource() {
		return $this->resource;
	}

	public function getControllerClassName() {
		return $this->controllerClassName;
	}

	public function getControllerFileName() {
		return $this->controllerFileName;
	}

	public function getActionMethodName() {
		return $this->actionMethodName;
	}

	public function getBodyParams() {
		return $this->bodyParams;
	}
}