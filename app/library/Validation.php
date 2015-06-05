<?php

/**
* This helper class to handle data validation.
*
* @package    gamerest
*/

class Validation {

	/**
	* Chechk if the string passed is json
	*
	* @param string $string Json string to be validated
	* @return bool is true if it is a proper json
	*/
	public static function isJson ($string) {
		json_decode($string);
 		return (json_last_error() == JSON_ERROR_NONE);	
	}



	/** 
	* Chechk if the string passed is a json string that has the structure of a Character
	*
	* @param string $string Json string to be validated
	* @return bool is true if is a proper character
	*/
	public static function validCharacter (){
		return true; // Something I would like to finish, thit is actually not done
	}
}