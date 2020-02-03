<?php


namespace ree\coin;


use ree\coin\data\DataBaseManager;

class ReefCoinAPI implements ReefCoinAPI_Base
{
	/**
	 * @inheritDoc
	 */
	public static function isExists(string $name): bool
	{
		return ReefCoinSystemCore::getDataBaseManager()->isExists($name);
	}

	/**
	 * @inheritDoc
	 */
	public static function getAll(): array
	{
		return ReefCoinSystemCore::getDataBaseManager()->getAllData();
	}

	/**
	 * @inheritDoc
	 */
	public static function getCoin(string $name): int
	{
		return ReefCoinSystemCore::getDataBaseManager()->getCoin($name);
	}

	/**
	 * @inheritDoc
	 */
	public static function setCoin(string $name, float $coin): void
	{
		$coin = self::round($coin);
		ReefCoinSystemCore::getDataBaseManager()->setCoin($name ,$coin);
		return;
	}

	/**
	 * @inheritDoc
	 */
	public static function addCoin(string $name, float $coin): void
	{
		$coin = self::getCoin($name) + $coin;
		self::setCoin($name ,$coin);
		return;
	}

	/**
	 * @inheritDoc
	 */
	public static function removeCoin(string $name, float $coin): bool
	{
		if (self::getCoin($name) >= $coin)
		{
			$coin = self::getCoin($name) + $coin;
			self::setCoin($name ,$coin);
			return true;
		}else{
			return false;
		}
	}

	/**
	 * @inheritDoc
	 */
	public static function payCoin(string $send, string $receive ,int $coin): bool
	{
		if (self::isExists($send) and self::isExists($receive) and self::getCoin($send) >= $coin)
		{
			self::addCoin($receive ,$coin);
			return self::removeCoin($send ,$coin);
		}
		return false;
	}

	private static function round(float $coin): float
	{
		return round($coin ,self::FLOAT + 1);
	}
}