<?php

class CharacterController {

	public function getCharacter(DatabaseConnection $db, $id) {

		return Character::find($db, $id);
	}

	public function postCharacter(DatabaseConnection $db, $params) {

		$db->query('INSERT INTO characters(name, description, type, dead, stage, hp) 
			VALUES(:name, :description, :type, :dead, :stage, :hp);', $params);

		$id = $db->lastID();

		$array = $db->selectRowByID('SELECT * FROM characters WHERE id = ?;', $id);

		return $array;
	}

	public function putCharacter(DatabaseConnection $db, $id, $params) {

		Character::update($db, $id, $params);

		$character = Character::find($db, $id);

		return $character;
	}

	public function deleteCharacter(DatabaseConnection $db, $id) {

		Character::delete($db, $id);

		return '{}';
	}
}