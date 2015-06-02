<?php

class Response {

	public function execute($body, $status_code) {

		header('Content-Type: application/json');
		
		http_response_code($status_code);

		echo json_encode($body);
	}
}