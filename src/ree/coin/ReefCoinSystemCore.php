<?php


namespace ree\coin;


use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat;
use ree\coin\data\DataBaseManager;
use ree\coin\listener\EventListener;
use ree\sub\client\ReefCoinClient;
use ree\sub\land\ReefLand;

class ReefCoinSystemCore extends PluginBase
{
	const GOOD = 'ReefCoinSystem '.TextFormat::GREEN.'>> '.TextFormat::RESET;
	const BAD = 'ReefCoinSystem '.TextFormat::GOLD.'>> '.TextFormat::RESET;
	const ERROR = 'ReefCoinSystem '.TextFormat::RED.'>> '.TextFormat::RESET;

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
		$this->sendInfo();
		$this->getLogger()->info(self::getCoreName().TextFormat::DARK_PURPLE.'Enable');
		parent::onEnable();
	}

	public function sendInfo(): void
	{
		echo "\n".'RRRRRR                 fff  CCCCC         iii          SSSSS                tt'."\n";
		echo 'RR   RR   eee    eee  ff   CC    C  oooo      nn nnn  SS      yy   yy  sss  tt      eee  mm mm mmmm'."\n";
		echo 'RRRRRR  ee   e ee   e ffff CC      oo  oo iii nnn  nn  SSSSS  yy   yy s     tttt  ee   e mmm  mm  mm'."\n";
		echo 'RR  RR  eeeee  eeeee  ff   CC    C oo  oo iii nn   nn      SS  yyyyyy  sss  tt    eeeee  mmm  mm  mm'."\n";
		echo 'RR   RR  eeeee  eeeee ff    CCCCC   oooo  iii nn   nn  SSSSS       yy     s  tttt  eeeee mmm  mm  mm'."\n";
		echo '                                                               yyyyy   sss'."\n\n";
	}

	public static function getDataBaseManager(): DataBaseManager
	{
		return self::$data;
	}

	public static function getVersion(): string
	{
		return self::$instance->getDescription()->getVersion();
	}

	public static function getCoreName(): string
	{
		return TextFormat::GREEN.'Reef'.TextFormat::GOLD.'Coin'.TextFormat::AQUA.'System'.TextFormat::RESET.' Ver'.self::getVersion();
	}

	public function onDisable()
	{
		parent::onDisable();
	}
}