<?php

/**
* Class model of Character
*
* @package gamerest
*/
class Character {


	/**
	 * Given an ID, finds a character with that ID
	 * 
	 * @throws StatusCodeException if was not success
	 * 
	 * @param DatabaseConnection database class instance
	 * @param mixed $id ID number, could be a string or an int
	 * @return array row of the database with that ID
	 */
	public static function find(DatabaseConnection $db, $id) {

		$array = $db->selectRowByID('SELECT * FROM characters WHERE id = ?', $id);

		if ( $array === NULL ) throw new StatusCodeException(404);

		return $array;
	}


	/**
	 * Insert a row in the characters table
	 *
	 * @throws StatusCodeException 500 if was not success
	 * 
	 * @param DatabaseConnection database class instance
	 * @param array $character character attributes without id 
	 * @return string ID of character inserted
	 */
	public static function insert(DatabaseConnection $db, $character) {

		$success = $db->query('INSERT INTO characters(name, description, type, dead, stage, hp) 
			VALUES(:name, :description, :type, :dead, :stage, :hp);', $character);

		$id = Self::lastID($db);

		if ( ! $success ) throw new StatusCodeException(500);

		return $id;
	}



	/**
	 * Update a character with that ID
	 *
	 * @throws StatusCodeException 404 if was not success
	 * 
	 * @param DatabaseConnection database class instance
	 * @param mixed ID number, could be a string or an int
	 * @param array $character character attributes without id 
	 */
	public static function update(DatabaseConnection $db, $id, $character) {

		$character['id'] = $id;

		$success = $db->query("UPDATE characters SET

			name 		= :name,
			description = :description,
			type		= :type,
			dead		= :dead,
			stage		= :stage,
			hp			= :hp

			WHERE id = :id", $character );

		if ( ! $success ) throw new StatusCodeException(404);
	}



	/**
	 * Delete the character with that ID
	 * 
	 * @throws StatusCodeException 404 if was not success
	 *
	 * @param DatabaseConnection database class instance
	 * @param mixed ID number, could be a string or an int
	 */
	public static function delete(DatabaseConnection $db, $id) {

		$success = $db->query('DELETE FROM characters WHERE id = ?;', [$id]);

		if ( ! $success ) throw new StatusCodeException(404);
	}


	/**
	 * Get the ID of the last row inserted
	 * 
	 * @throws StatusCodeException if was not success
	 *
	 * @param DatabaseConnection database class instance
	 * @return string returns the id of the last row inserted
	 */
	private static function lastID(DatabaseConnection $db) {

		return $db->lastID();

	}
}