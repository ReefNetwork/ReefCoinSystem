<?php

namespace ree\coin\data;


use SQLite3;


class DataBaseManager implements DataBaseAPI_Base
{

	/**
	 * @var SQLite3
	 */
	private $db;

	/**
	 * @inheritDoc
	 */
	public function __construct(string $pass)
	{
		$this->db = new SQLite3($pass);
		$this->setTable();
	}

	private function setTable(): void
	{
		$this->db->exec('CREATE TABLE IF NOT EXISTS moneys (name TEXT NOT NULL PRIMARY KEY ,money NUMERIC NOT NULL )');
	}

	private function close(): void
	{
		$this->db->close();
	}

	/**
	 * @inheritDoc
	 */
	public function setCoin(string $name, string $coin): bool
	{
		$name = strtolower($name);
		$stmt = $this->db->prepare('REPLACE INTO moneys (name ,money) VALUES (:name ,:money)');
		$stmt->bindValue(':money', $coin, SQLITE3_INTEGER);
		$stmt->bindParam(':name', $name, SQLITE3_TEXT);
		$stmt->execute();
		return true;
	}

	/**
	 * @inheritDoc
	 */
	public function getCoin(string $name)
	{
		$name = strtolower($name);
		$stmt = $this->db->prepare('SELECT money FROM moneys WHERE (name = :name)');
		$stmt->bindParam(':name', $name, SQLITE3_TEXT);
		if (isset($stmt->execute()->fetchArray(SQLITE3_ASSOC)['money']))
		{
			$stmt = $this->db->prepare('SELECT money FROM moneys WHERE (name = :name)');
			$stmt->bindParam(':name', $name, SQLITE3_TEXT);
			return $stmt->execute()->fetchArray(SQLITE3_ASSOC)['money'];
		}else{
			return 0;
		}

	}

	/**
	 * @inheritDoc
	 */
	public function getAllData(): array
	{
		$stmt = $this->db->prepare('SELECT money FROM moneys');
		return $stmt->execute()->fetchArray(SQLITE3_ASSOC);
	}

	public function registar(string $name): void
	{

	}
}