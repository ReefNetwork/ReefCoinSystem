<?php


namespace ree\coin\data;


use SQLite3;

interface DataBaseAPI_Base
{
	/**
	 * DataBaseAPI_Base constructor.
	 * @param string $db
	 */
	public function __construct(string $db);

	/**
	 * @param string $name
	 * @param string $coin
	 * @return bool
	 */
	public function setCoin(string $name,string $coin): bool;

	/**
	 * @param string $name
	 * @return mixed
	 */
	public function getCoin(string $name);

	/**
	 * @return array
	 */
	public function getAllData(): array;
}