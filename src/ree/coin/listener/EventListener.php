<?php


namespace ree\coin\listener;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerLoginEvent;
use ree\coin\ReefCoinAPI;
use ree\coin\ReefCoinSystemCore;

class EventListener implements Listener
{
	/**
	 * @var int
	 */
	private static $defaultCoin = 0;

	public function onLogin(PlayerLoginEvent $ev)
	{
		$p = $ev->getPlayer();
		$n = $p->getName();
		if (!ReefCoinAPI::isExists($n))
		{
			ReefCoinAPI::setCoin($n ,self::$defaultCoin);
			$p->sendMessage(ReefCoinSystemCore::GOOD.'create new account');
		}
	}

	public static function setDefaultCoin(int $coin): void
	{
		self::$defaultCoin = $coin;
	}

	public static function getDefaultCoin(): int
	{
		return self::$defaultCoin;
	}
}