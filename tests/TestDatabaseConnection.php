<?php

require_once __DIR__ . '/../app/library/DatabaseConnection.php';
require_once __DIR__ . '/../app/library/Response.php';

class TestDatabase extends PHPUnit_Framework_TestCase {


	public function testDatabaseSelectRowByIDBehaviour () {

		require __DIR__ . '/config/database_test.php';

		$db = new DatabaseConnection($host, $database, $user, $password);

		// Test of a character that actually exist
		$id1 = 3;
		$actual1 = $db->selectRowByID('SELECT * FROM characters WHERE id = ?;', $id1);
		$expected1 = [
			'id' 			=> '3',
			'name' 			=> 'Peter Akarisawa',
			'description' 	=> 'The greatest cyborg samurai golf player',
			'type' 			=> 'ninja',
			'dead' 			=> '0',
			'stage' 		=> '1',
			'hp' 			=> '45'
		];


		$id2 = 8888;
		$actual2 = $db->selectRowByID('SELECT * FROM characters WHERE id = ?;', $id2);

		$this->assertNotEmpty($expected1, 'function select returning an empty value');
		$this->assertEquals($expected1, $actual1, 'Expected and actual not matching.');

		$this->assertEmpty($actual2, 'message');

	}


	public function testDatabaseQueryBehaviour () {

		require __DIR__ . '/config/database_test.php';

		$db = new DatabaseConnection($host, $database, $user, $password);

		$insert_result = $db->query("INSERT INTO characters (id, name, description, type, dead, stage, hp) 
			VALUES ('9999', 'Carla', 'The swordmaster of Melee Island', 'pirate', 'false',  '4',  '87');");


		$expected = [
			'id' 			=> '9999',
			'name' 			=> 'Carla',
    		'description' 	=> 'The swordmaster of Melee Island',
    		'type' 			=> 'pirate',
    		'dead' 			=> '0',
    		'stage' 		=> '4',
    		'hp' 			=> '87'
		];

		$actual = $db->selectRowByID("SELECT * FROM characters WHERE id = '9999'");

		$delete_result = $db->query("DELETE FROM characters WHERE id = '9999'");

		$this->assertNotEmpty($actual, 'Function query returning an empty value.');
		$this->assertEquals($expected, $actual, 'Function query not returning expected value.');
		$this->assertTrue($insert_result, 'Insert query failed.');
		$this->assertTrue($delete_result, 'Delete query failed.');
	}


	public function testDatabaseLastIDBehaviour () {

		require __DIR__ . '/config/database_test.php';

		$db = new DatabaseConnection($host, $database, $user, $password);

		$insert_result = $db->query("INSERT INTO characters (id, name, description, type, dead, stage, hp) 
			VALUES ('9999', 'Carla', 'The swordmaster of Melee Island', 'pirate', 'false',  '4',  '87');");

		$actual = $db->lastID();

		$expected = '9999';

		$delete_result = $db->query("DELETE FROM characters WHERE id = '9999'");

		$this->assertNotEmpty($actual, 'Function LastID returning empty value.');
		$this->assertEquals($expected, $actual, 'Function LastID not returning expected value.');
	}



}