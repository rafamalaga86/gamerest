<?php

require_once __DIR__ .  '/../app/library/DatabaseConnection.php';
require_once __DIR__ .  '/../app/controllers/CharacterController.php';

class TestCharacterController extends PHPUnit_Framework_TestCase {


	public function testGetControllerBehaviour() {

		require __DIR__ . '/config/database_test.php';

		$controller = new CharacterController();
		$actionMethodName = 'getCharacter';
		$db = new DatabaseConnection($host, $database, $user, $password);
		$id = 2;

		$actual = call_user_func_array( [$controller, $actionMethodName] , [$db, [$id]] );

		$expected = [
			'id' => '2',
			'name' => 'Guybrush Threepwood',
			'description' => 'How appropriate. You fight like a cow',
			'type' => 'pirate',
			'dead' => '0',
			'stage' => '5',
			'hp' => '100'
		];

		$this->assertEquals($expected, $actual);
	}


	public function testPostControllerBehaviour() {

		require __DIR__ . '/config/database_test.php';

		

/*		

		$controller = new CharacterController();
		$actionMethodName = 'postCharacter';
		$db = new DatabaseConnection($host, $database, $user, $password);
		$id = 2;

		call_user_func_array( [$controller, $actionMethodName] , [$db, [$id]] );

		*/
	}

/*
	public function testPutControllerBehaviour() {

		require __DIR__ . '/config/database_test.php';

		$controller = new CharacterController();
		$actionMethodName = 'putCharacter';
		$db = new DatabaseConnection($host, $database, $user, $password);
		$id = 2;

		call_user_func_array( [$controller, $actionMethodName] , [$db, $id] );
	}


	public function testDeleteControllerBehaviour() {

		require __DIR__ . '/config/database_test.php';

		$controller = new CharacterController();
		$actionMethodName = 'deleteCharacter';
		$db = new DatabaseConnection($host, $database, $user, $password);
		$id = 2;

		call_user_func_array( [$controller, $actionMethodName] , [$db, $id] );
	}
*/


/*
	public function postCharacter(DatabaseConnection $db, $params) {

		$array = array();

		$array = $db->insert('INSERT INTO characters() VALUES()');

		return $array;
	}

	public function putCharacter($params) {
		echo "putCharacter";

	}

	public function deleteCharacter($id) {
		echo "deleteCharacter";

	}*/
}