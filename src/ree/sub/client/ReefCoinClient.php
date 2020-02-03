<?php


namespace ree\sub\client;


use pocketmine\Server;
use pocketmine\utils\TextFormat;
use ree\coin\ReefCoinSystemCore;
use ree\sub\client\command\PayCommand;

class ReefCoinClient
{
	const GOOD = 'ReefCoinClient '.TextFormat::GREEN.'>> '.TextFormat::RESET;
	const BAD = 'ReefCoinSClient '.TextFormat::GOLD.'>> '.TextFormat::RESET;
	const ERROR = 'ReefCoinClient '.TextFormat::RED.'>> '.TextFormat::RESET;

	/**
	 * @var ReefCoinSystemCore
	 */
	private static $instance;

	public static function load(ReefCoinSystemCore $main): void
	{
		if (self::$instance)
		{
			$main->getLogger()->error(self::ERROR.'Trying to call load twice');
			Server::getInstance()->getPluginManager()->disablePlugin($main);
			return;
		}
		self::$instance = new ReefCoinClient();
		Server::getInstance()->getCommandMap()->register('pay' ,new PayCommand());
		$main->getLogger()->info(self::GOOD.'loaded');
	}
}