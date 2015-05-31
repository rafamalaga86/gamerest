<?php

class Response {

	static public function json($content, $status_code) {

		echo json_encode($content);

		header('Content-Type: application/json');
		http_response_code($status_code);
		exit();

	}
}