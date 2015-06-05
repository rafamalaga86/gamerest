<?php

require_once __DIR__ . '/../app/library/Validation.php';


class TestValidation extends PHPUnit_Framework_TestCase {

	public function testIsJson() {

		$json1 = '{}';
		$json2 = '{"character":"peter"}';
		$json3 = '{"id":"2","name":"Guybrush Threepwood","description":{"level1":{"asdf":"asdf"}},"type":"pirate","dead":"0","stage":"5","hp":"100"}';

		$this->assertTrue(Validation::isJson($json1), "Not recognizing empty JSONs");
		$this->assertTrue(Validation::isJson($json2), "Not recognizing one level JSONs");
		$this->assertTrue(Validation::isJson($json3), "Not recognizing multi level JSONs");
	}

}