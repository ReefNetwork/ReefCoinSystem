<?php


namespace ree\coin;


use pocketmine\plugin\PluginBase;
use ree\coin\data\DataBaseManager;
use ree\coin\listener\EventListener;
use ree\sub\client\ReefCoinClient;
use ree\sub\land\ReefLand;

class ReefCoinSystemCore extends PluginBase
{
	/**
	 * @var ReefCoinSystemCore
	 */
	private static $instance;

	/**
	 * @var DataBaseManager
	 */
	private static $data;

	public function onLoad()
	{
		self::$instance = $this;
		self::$data = new DataBaseManager($this->getDataFolder().'date.db');
		parent::onLoad();
	}

	public function onEnable()
	{
		$this->getServer()->getPluginManager()->registerEvents(new EventListener() ,$this);
		echo 'ReefCoinSystemCore >> Loading subsystem...'."\n";
		ReefCoinClient::load($this);
		ReefLand::load($this);
		echo 'ReefCoinSystemCore >> Complete'."\n";
		parent::onEnable();
	}

	public static function getDataBaseManager(): DataBaseManager
	{
		return self::$data;
	}

	public function onDisable()
	{
		parent::onDisable();
	}
}