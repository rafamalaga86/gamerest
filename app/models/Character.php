<?php

/**
* Class model of Character
*
* @package gamerest
*/
class Character {
	

	/**
	 * Get the ID of the last row inserted
	 *
	 * @param DatabaseConnection database class instance
	 * @param mixed $id ID number, could be a string or an int
	 * @return array row of the database with that ID
	 */
	public static function findCharacter(DatabaseConnection $db, $id) {



	}


	/**
	 * Get the ID of the last row inserted
	 *
	 * @param DatabaseConnection database class instance
	 * @param array $character character attributes without id 
	 * @return bool returns true is success, false if it wasn't
	 */
	public static function insertCharacter(DatabaseConnection $db, $character) {



	}



	/**
	 * Get the ID of the last row inserted
	 *
	 * @param DatabaseConnection database class instance
	 * @param mixed ID number, could be a string or an int
	 * @param array $character character attributes without id 
	 * @return bool returns true is success, false if it wasn't
	 */
	public static function updateCharacter(DatabaseConnection $db, $id, $character) {



	}



	/**
	 * Get the ID of the last row inserted
	 *
	 * @param DatabaseConnection database class instance
	 * @param mixed ID number, could be a string or an int
	 * @return bool returns true is success, false if it wasn't
	 */
	public static function deleteCharacter(DatabaseConnection $db, $id) {



	}
}