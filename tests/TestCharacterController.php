<?php

require_once __DIR__ .  '/../app/library/DatabaseConnection.php';
require_once __DIR__ .  '/../app/library/StatusCodeException.php';
require_once __DIR__ .  '/../app/models/Character.php';
require_once __DIR__ .  '/../app/controllers/CharacterController.php';

class TestCharacterController extends PHPUnit_Framework_TestCase {

	/**
    * @expectedException StatusCodeException
	* @expectedExceptionCode 404
    */
	public function testGetController() {

		require __DIR__ . '/config/database_test.php';

		$controller = new CharacterController();
		$actionMethodName = 'getCharacter';
		$db = new DatabaseConnection($host, $database, $user, $password);

		// Trying to get a Character that exists
		$id1 = 2;
		$actual1 = call_user_func_array( [$controller, $actionMethodName] , [$db, $id1] );

		$expected1 = [
			'id' => '2',
			'name' => 'Guybrush Threepwood',
			'description' => 'How appropriate. You fight like a cow',
			'type' => 'pirate',
			'dead' => '0',
			'stage' => '5',
			'hp' => '100'
		];

		$this->assertEquals($expected1, $actual1, 'Not retrieving the same Character than expected.');



		// Trying to get a character that does not exist.
		$id2 = 8888;
		$actual2 = call_user_func_array( [$controller, $actionMethodName] , [$db, $id2] );

	}

	/**
	* @expectedException     StatusCodeException
	* @expectedExceptionCode 404
	*/
	public function testPostControllerAndDeleteController() {

		require __DIR__ . '/config/database_test.php';

		$controller = new CharacterController();
		$actionMethodName = 'postCharacter';
		$db = new DatabaseConnection($host, $database, $user, $password);


		// Test PostController
		$params = [
			'name' => 'Guybrush Threepwood',
			'description' => 'How appropriate. You fight like a cow',
			'type' => 'pirate',
			'dead' => '0',
			'stage' => '5',
			'hp' => '100'
		];


		$actual = call_user_func_array( [$controller, $actionMethodName] , [$db, $params] );

		$id = $actual['id'];
		unset($actual['id']);

		$this->assertEquals($params, $actual, 'Inserted row not the same that expected');


		// Testing DeleteController

		$actionMethodName = 'deleteCharacter';
		$actual = call_user_func_array( [$controller, $actionMethodName] , [$db, $id] );

		Character::find($db, $id);

	}

	public function testPutController() {

		require __DIR__ . '/config/database_test.php';

		$controller = new CharacterController();
		$actionMethodName = 'putCharacter';
		$db = new DatabaseConnection($host, $database, $user, $password);

		$id = 2;

		$params = [
			'name' => 'Guybrush Threepwood',
			'description' => 'How appropriate. You fight like a cow',
			'type' => 'pirate',
			'dead' => '0',
			'stage' => '5',
			'hp' => '100'
		];

		$actual = call_user_func_array( [$controller, $actionMethodName] , [$db, $id, $params] );

		$expected = $params;
		$expected['id'] = $id;

		$this->assertEquals($expected, $actual, 'Updated row not same as expected');
	}

}