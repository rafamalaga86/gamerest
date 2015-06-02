<?php

class CharacterController {

	public function getCharacter(DatabaseConnection $db, $id) {

		$array = $db->selectRowByID('SELECT * FROM characters WHERE id LIKE ?', $id);

		return $array;
	}

	public function postCharacter(DatabaseConnection $db, $params) {

		$db->query('INSERT INTO characters(name, description, type, dead, stage, hp) 
			VALUES(:name, :description, :type, :dead, :stage, :hp);', $params);

		$id = $db->lastID();

		$array = $db->selectRowByID('SELECT * FROM characters WHERE id = ?;', $id);

		return $array;
	}

	public function putCharacter(DatabaseConnection $db, $id, $params) {

		$params['id'] = $id;

		$result = $db->query("UPDATE characters SET

			name 		= :name,
			description = :description,
			type		= :type,
			dead		= :dead,
			stage		= :stage,
			hp			= :hp

			WHERE id = :id", $params );

		$array = $db->selectRowByID('SELECT * FROM characters WHERE id = ?;', $id);

		return $array;
	}

	public function deleteCharacter(DatabaseConnection $db, $id) {


		$success = $db->query('DELETE FROM characters WHERE id = ?;', [$id]);

		if ($success){

			$string = '{}';

		}

		return $string;
	}
}