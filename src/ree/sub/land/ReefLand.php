<?php


namespace ree\sub\land;


use pocketmine\Server;
use pocketmine\utils\TextFormat;
use ree\coin\ReefCoinSystemCore;
use ree\sub\land\sql\LandDataBaseManager;

class ReefLand
{
	const GOOD = 'ReefLandSystem '.TextFormat::GREEN.'>> '.TextFormat::RESET;
	const BAD = 'ReefLandSystem '.TextFormat::GOLD.'>> '.TextFormat::RESET;
	const ERROR = 'ReefLandSystem '.TextFormat::RED.'>> '.TextFormat::RESET;

	/**
	 * @var ReefLand
	 */
	private static $instance;

	public static $data;

	/**
	 * @param ReefCoinSystemCore $main
	 */
	public static function load(ReefCoinSystemCore $main): void
	{
		if (self::$instance)
		{
			$main->getLogger()->error(self::ERROR.'Trying to call load twice');
			Server::getInstance()->getPluginManager()->disablePlugin($main);
			return;
		}
		self::$instance = new ReefLand();
		self::$data = new LandDataBaseManager($main->getDataFolder().'land.db');
		$main->getLogger()->info(self::GOOD.'loaded');
	}

	/**
	 * @return LandDataBaseManager
	 */
	public static function getDataBaseManager(): LandDataBaseManager
	{
		return self::$data;
	}
}