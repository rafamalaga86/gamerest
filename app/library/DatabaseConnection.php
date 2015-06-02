<?php

/**
* This class take care of the database connection. It does it with PDO.
*
* @package gamerest
*/
class DatabaseConnection {

	private $pdo;

	/**
	 *
	 * @param string $host host of the database
	 * @param string $database name of the database
	 * @param string $user user for the connection to work
	 * @param string $password password of the user
	 */
	public function __construct ($host, $database, $user, $password) {

		try {

			if ( !isset($host) || !isset($database) || !isset($user) || !isset($password) )
				throw new PDOException('Error: No database data. Fill up the config/database.php file.');


			$pdo = new PDO( "mysql:host=$host;dbname=$database;charset=utf8", $user, $password,
				[
					PDO::MYSQL_ATTR_LOCAL_INFILE => true,
					PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				]
			);
		}

		catch (PDOException $exception) {
			die('500');
		}

		$this->pdo = $pdo;
	}




	/**
	 * Let us make SELECTS that returns only one row
	 *
	 * @param string $query The SELECT query
	 * @param array $values Array of values that the select query would need
	 * @return array $result Row selected
	 */
	public function selectRowByID ($query, $values = NULL) {

		try {

			$statement = $this->pdo->prepare( $query );
			$statement->execute( [$values] );

			$result = $statement->fetch(PDO::FETCH_ASSOC);

			if ( ! $result ) throw new PDOException("404 Not found");

			return $result;
		}

		catch (PDOException $exception) {

			die("Error: " . $exception->getMessage() );
		}

	}




	/**
	 * Let us make non-select QUERY
	 *
	 * @param string $query The non-select query
	 * @param array $values Array of values that the select query would need
	 * @return boolean $success Row selected
	 */
	public function query ($query, $values = NULL) {

		try {

			$statement = $this->pdo->prepare( $query );
			$success = $statement->execute( $values );

			if ( ! $success ) throw new PDOException("404 QUERY FAILS");

			return $success;
		}

		catch (PDOException $exception) {

			die("Error: " . $exception->getMessage() );
		}

	}



	/**
	 * Get the ID of the last row inserted
	 *
	 * @return string ID of the last row
	 */
	public function lastID () {

		return $this->pdo->lastInsertId();
	}



}
