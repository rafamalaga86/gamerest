<?php

require_once __DIR__ . '/../app/library/DatabaseConnection.php';
require_once __DIR__ . '/../app/library/Response.php';

class TestDatabase extends PHPUnit_Framework_TestCase {

	public function testDatabaseConnectBehaviour () {

		require __DIR__ . '/../app/config/database.php';

		$db = new DatabaseConnection($host, $database, $user, $password);

	}

	public function testDatabaseStatementBehaviour () {

	}
}