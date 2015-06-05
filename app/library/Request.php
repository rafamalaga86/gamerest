<?php

class Request {

	private $verb;
	private $url;
	private $segments;
	private $contentType = 'text/plain';
	private $resource;
	private $controllerClassName;
	private $controllerFileName;
	private $actionMethodName;
	private $modelFileName;
	private $bodyParams = NULL;
	private $statusCode = 200;


	public function __construct($server) {

		$this->verb = strtolower($server['REQUEST_METHOD']);
		$this->url = $server['PATH_INFO'];

		$this->segments = explode('/', $this->url);
		array_shift($this->segments);

		if ( isset($server['CONTENT_TYPE']) ) 
			$this->contentType = $server['CONTENT_TYPE'];

		$this->resource = ucfirst(array_shift( $this->segments ));
		$this->controllerClassName = $this->resource . 'Controller';
		$this->controllerFileName = 'controllers/' . $this->controllerClassName . '.php';
		$this->actionMethodName = $this->verb . $this->resource;
		$this->modelFileName = 'models/' . $this->resource . '.php';

		if ( $this->verb == 'put' || $this->verb == 'post' ){
			$this->bodyParams = $this->parseBodyParams();

			if ( ! Validation::validCharacter($this) )
				$this->setStatusCode(400); // Not a proper Character 
		}

	}

	public function parseBodyParams() {

			if ( $this->getContentType() != 'application/json')
				$this->setStatusCode(400); // We only accept json at the momment

			$bodyParams = array();
			$body = file_get_contents("php://input");

			if ( ! Validation::isJson($body) )
				$this->setStatusCode(400); // Data sent is not json

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


		if ( ! file_exists($controllerFileName) )
			$this->setStatusCode(400);


		if ( $verb == 'get' || $verb == 'delete') {

			$function_params = [$db, $id];

		} elseif ($verb == 'put') {

			$function_params = [$db, $id, $bodyParams];

		} else if ($verb == 'post') {

			$function_params = [$db, $bodyParams];

		} else {

			$this->setStatusCode(400);
		}

		require $modelFileName;
		require $controllerFileName;

		$controller = new $controllerClassName();

		try {

			$responseBody = call_user_func_array([$controller, $actionMethodName], $function_params);

		}

		catch (StatusCodeException $exception) {

			$code = $exception->getCode();
			$this->setStatusCode( $code );
			$responseBody = $exception->getMessage();

		}


		$this->execute($this->getStatusCode(), $responseBody);
	}


	private function execute($code, $responseBody = NULL){

		if ( is_string($responseBody) && $code == 200 ) {

			http_response_code($code);
			echo $responseBody;

		} elseif ( is_array($responseBody) && $code == 200 ){

			http_response_code($code);
			echo json_encode($responseBody);

		} elseif ( $code == 200 ){ 

			 // There is a problem, if it is ok the response should be array or string
			$code == 500;
			http_response_code($code);

		} else {

			http_response_code($code);

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
		return $this->contentType;
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

	public function getStatusCode(){
		return $this->statusCode;
	}

	public function setStatusCode( $code ) {
		$this->statusCode = $code;
	}
}