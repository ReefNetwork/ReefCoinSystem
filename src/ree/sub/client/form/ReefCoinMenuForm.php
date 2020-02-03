<?php


namespace ree\sub\client\form;


use pocketmine\form\Form;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use ree\coin\ReefCoinAPI;
use ree\coin\ReefCoinSystemCore;
use ree\sub\client\ReefCoinClient;

class ReefCoinMenuForm implements Form
{
	/**
	 * @var string
	 */
	private $name;

	/**
	 * ReefCoinMenuForm constructor.
	 * @param string $name
	 */
	public function __construct(string $name = null)
	{
	}

	/**
	 * @inheritDoc
	 */
	public function handleResponse(Player $player, $data): void
	{
		if ($data === null)
		{
			return;
		}
		switch ($data)
		{
			case 0:

				break;

			default:
				$player->sendMessage(ReefCoinClient::ERROR.get_class($this).' result not fond');
				break;
		}
	}

	/**
	 * @inheritDoc
	 */
	public function jsonSerialize()
	{
		$string = '';
		if ($this->name)
		{
			$string = '現在の所持金は'.ReefCoinAPI::getCoin($this->name).'です';
		}
		return [
			'type' => 'form',
			'title' => TextFormat::GREEN.'Reef'.TextFormat::GOLD.'Coin'.TextFormat::AQUA.'System'.TextFormat::RESET.'Ver.'.ReefCoinSystemCore::getVersion(),
			'content' => $string,
			'buttons' => [
				[
					'text' => '送金する'
				],
				[
					'text' => '土地保護メニュー'
				],
			]
		];
	}
}