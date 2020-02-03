<?php


namespace ree\coin\listener;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use ree\coin\ReefCoinAPI;
use ree\coin\ReefCoinSystemCore;

class EventListener implements Listener
{
	/**
	 * @var int
	 */
	public $newAccountMoney = 9999999999;

	public function onJoin(PlayerJoinEvent $ev)
	{
		$p = $ev->getPlayer();
		$n = $p->getName();
		if (!ReefCoinAPI::isExists($n))
		{
			ReefCoinAPI::setCoin($n ,$this->newAccountMoney);
			$p->sendMessage(ReefCoinSystemCore::GOOD.'アカウントを作成しました');
		}
	}
}