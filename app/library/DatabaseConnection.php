<?php

class DatabaseConnection {

	private $pdo;

	public function __construct($host, $database, $user, $password) {

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

	public function statement($query, $values = NULL) {

		try {

			$statement = $pdo->prepare( $query );
			$statement->execute( $values );
		}

		catch (PDOException $exception) {

		    die("Error: " . $exception->getMessage() );
		}

	}

}
