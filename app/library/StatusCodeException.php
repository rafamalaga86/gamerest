<?php

/**
* Class Exception for handling the REST API status codes.
*
* @package gamerest
*/
class StatusCodeException extends Exception {

	private $codesMeaning = [
		100 => 'Continue',
		200 => 'OK',
		201 => 'Created',
		202 => 'Accepted',
		203 => 'Non-Authoritative Information',
		204 => 'No Content',
		205 => 'Reset Content',
		206 => 'Partial Content',
		300 => 'Multiple Choices',
		301 => 'Moved Permanently',
		302 => 'Found',
		303 => 'See Other',
		304 => 'Not Modified',
		305 => 'Use Proxy',
		307 => 'Temporary Redirect',
		400 => 'Bad Request',
		401 => 'Unauthorized',
		402 => 'Payment Required',
		403 => 'Forbidden',
		404 => 'Not Found',
		405 => 'Method Not Allowed',
		406 => 'Not Acceptable',
		409 => 'Conflict',
		410 => 'Gone',
		411 => 'Length Required',
		412 => 'Precondition Failed',
		413 => 'Request Entity Too Large',
		414 => 'Request-URI Too Long',
		415 => 'Unsupported Media Type',
		416 => 'Requested Range Not Satisfiable',
		417 => 'Expectation Failed',
		500 => 'Internal Server Error',
		501 => 'Not Implemented',
		503 => 'Service Unavailable'
	];


	/**
	 * Make a construct where we only need the status code,
	 * and we could get the message. However, we can also customise
	 * the message of the exception
	 * 
	 * @param int $code Status Code number of the StatusCodeException
	 * @param string $message The message of the StatusCodeException
	 */
	public function __construct($code, $message = NULL) {

		if ( $message == NULL )
			$message = $this->getStatusMessage($code);

		parent::__construct($message, $code);
	}

	private function getStatusMessage($code) {

		if ( array_key_exists($code, $this->codesMeaning) )
			$message = $this->codesMeaning[$code];

	}

}