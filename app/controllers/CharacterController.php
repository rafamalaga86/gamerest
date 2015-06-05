<?php

class CharacterController {


	/**
	 * Controller to execute when it receives a GET request on
	 * a Character resource.
	 * 
	 * @param DatabaseConnection database class instance
	 * @param mixed $id string or int ID of the character 
	 * @return array row of the database with that ID
	 */
	public function getCharacter(DatabaseConnection $db, $id) {

		return Character::find($db, $id);
	}




	/**
	 * Insert a row in the characters table
	 *
	 * @param DatabaseConnection database class instance
	 * @param array $params character attributes without id 
	 * @return array row inserted of the database with that ID
	 */
	public function postCharacter(DatabaseConnection $db, $params) {

		Character::insert($db, $params);

		$id = Character::lastID($db);

		$array = Character::find($db, $id);

		return $array;
	}




	/**
	 * Update a character with that ID
	 *
	 * @param DatabaseConnection database class instance
	 * @param mixed $id number, could be a string or an int
	 * @param array $params character attributes without id 
	 * @return array Row of character modified
	 */
	public function putCharacter(DatabaseConnection $db, $id, $params) {

		Character::update($db, $id, $params);

		$character = Character::find($db, $id);

		return $character;
	}







	/**
	 * Update a character with that ID
	 *
	 * @param DatabaseConnection database class instance
	 * @param mixed $id number, could be a string or an int
	 * @return string '{}'
	 */
	public function deleteCharacter(DatabaseConnection $db, $id) {

		Character::find($db, $id);

		Character::delete($db, $id);

		return '{}';
	}
}