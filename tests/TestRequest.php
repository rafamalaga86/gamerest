<?php


require_once __DIR__ . '/../app/library/Request.php';

class TestRequest extends PHPUnit_Framework_TestCase {

	public function testRequestBehaviour () {

		$url = 'character/23';
		$segments = ['character','23'];
		$verb = 'POST';

		$PATH_INFO = $url;
		$REQUEST_METHOD = $verb;

		$server = compact('PATH_INFO', 'REQUEST_METHOD');

		$request = new Request($server);

		$this->assertEquals($verb, $request->getVerb());
		$this->assertEquals($segments, $request->getSegments());
		$this->assertEquals($url, $request->getUrl());

		

	}

}