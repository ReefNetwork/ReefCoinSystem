<?php


namespace ree\coin;


interface ReefCoinAPI_Base
{
	/**
	 * Number of decimal places to save
	 * This is rounded
	 */
	const FLOAT = 3;

	/**
	 * @param string $name
	 * @return bool
	 */
	public static function isExists(string $name): bool ;

	/**
	 * @return array
	 */
	public static function getAll(): array ;

	/**
	 * @param string $name
	 * @return int
	 */
	public static function getCoin(string $name): int ;

	/**
	 * @param string $name
	 * @param float $coin
	 */
	public static function setCoin(string $name ,float $coin): void ;

	/**
	 * @param string $name
	 * @param float $coin
	 */
	public static function addCoin(string $name ,float $coin): void ;

	/**
	 * @param string $name
	 * @param float $coin
	 * @return bool
	 */
	public static function removeCoin(string $name ,float $coin): bool ;

	/**
	 * @param string $send
	 * @param string $receive
	 * @param int $coin
	 * @return bool
	 */
	public static function payCoin(string $send ,string $receive ,int $coin): bool ;
}