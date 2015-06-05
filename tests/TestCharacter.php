<?php

require_once __DIR__ .  '/../app/library/DatabaseConnection.php';
require_once __DIR__ .  '/../app/library/StatusCodeException.php';
require_once __DIR__ . '/../app/models/Character.php';

class TestCharacter extends PHPUnit_Framework_TestCase {

	public function testFind() {

		require __DIR__ . '/config/database_test.php';
		$db = new DatabaseConnection($host, $database, $user, $password);

		$characterActual1 = Character::find($db, 1);
		$characterActual2 = Character::find($db, '2');

		$characterExpected1 = ['id' => '1', 'name' => 'Lion Woods', 'description' => 'A wonderful zombie that plays golf better than Tiger Woods', 'type' => 'zombie', 'dead' => '1', 'stage' => '2', 'hp' => '67' ];
		$characterExpected2 = ['id' => '2', 'name' => 'Guybrush Threepwood', 'description' => 'How appropriate. You fight like a cow', 'type' => 'pirate', 'dead' => '0', 'stage' => '5', 'hp' => '100' ];

		$this->assertEquals($characterExpected1, $characterActual1, 'Character::find() function failing a test for id 1');
		$this->assertEquals($characterExpected2, $characterActual2, 'Character::find() function failing a test for id 2');

	}

	public function testInsertAndLastIDBehaviour() {

		require __DIR__ . '/config/database_test.php';
		$db = new DatabaseConnection($host, $database, $user, $password);

		$character1 = ['name' => 'Lion Woods', 'description' => 'A wonderful zombie that plays golf better than Tiger Woods', 'type' => 'zombie', 'dead' => '1', 'stage' => '2', 'hp' => '67' ];
		$character2 = ['name' => 'Guybrush Threepwood', 'description' => 'How appropriate. You fight like a cow', 'type' => 'pirate', 'dead' => '0', 'stage' => '5', 'hp' => '100' ];

		$id1 = Character::insert($db, $character1);
		$actualCharacter1 = Character::find($db, $id1);
		unset($actualCharacter1['id']);

		$id2 = Character::insert($db, $character2);
		$actualCharacter2 = Character::find($db, $id2);
		unset($actualCharacter2['id']);

		$this->assertEquals($character1, $actualCharacter1, 'Character::insert() function failing a test for Character1');
		$this->assertEquals($character2, $actualCharacter2, 'Character::insert() function failing a test for Character2');
	}


    /**
     * 
     * @expectedException StatusCodeException
     */
	public function testDelete() {

		require __DIR__ . '/config/database_test.php';
		$db = new DatabaseConnection($host, $database, $user, $password);

		$character1 = ['name' => 'Lion Woods', 'description' => 'A wonderful zombie that plays golf better than Tiger Woods', 'type' => 'zombie', 'dead' => '1', 'stage' => '2', 'hp' => '67' ];
		$id1 = Character::insert($db, $character1);
		
		$this->assertTrue( is_array(Character::find($db, $id1)), 'testDelete could not be done cause Character could not be inserted to be deleted.');

		Character::delete($db, $id1);

		$this->assertFalse( is_array(Character::find($db, $id1)), 'Character::delete not worked properly.');
	}

	public function testUpdate(){

		require __DIR__ . '/config/database_test.php';
		$db = new DatabaseConnection($host, $database, $user, $password);

		$character1 = ['name' => 'Lion Woods', 'description' => 'A wonderful zombie that plays golf better than Tiger Woods', 'type' => 'zombie', 'dead' => '1', 'stage' => '2', 'hp' => '67' ];
		$character2 = ['name' => 'Guybrush Threepwood', 'description' => 'How appropriate. You fight like a cow', 'type' => 'pirate', 'dead' => '0', 'stage' => '5', 'hp' => '100' ];

		$id = Character::insert($db, $character1);
		Character::update($db, $id, $character2);

		$actual = Character::find($db, $id);
		$character2['id'] = $id;
		$expected = $character2;

		$this->assertEquals($expected, $actual, 'Character::update() not working properly');
	}
}

