<?php


namespace ree\sub\client\form;


use pocketmine\form\Form;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use ree\coin\ReefCoinAPI;
use ree\coin\ReefCoinSystemCore;
use ree\sub\client\ReefCoinClient;

class ReefCoinPayForm implements Form
{
	/**
	 * @var string
	 */
	private $content;

	/**
	 * @var string
	 */
	private $nameParts;

	/**
	 * @var array
	 */
	private $names;

	/**
	 * ReefCoinPayForm constructor.
	 * @param string $content
	 * @param string|null $nameParts
	 */
	public function __construct(string $content = 'プレイヤーに送金出来ます' ,string $nameParts = null)
	{
		$this->content = $content;
		$this->nameParts = strtolower($nameParts);
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
		if (empty($this->names))
		{
			if (ReefCoinAPI::isExists($data[1]))
			{
				if (ReefCoinAPI::getCoin($player->getName()) >= $data[2] and is_numeric($data[2]) and $data[2] >= 0)
				{
					if (ReefCoinAPI::payCoin($player->getName() ,$data[1] ,$data[2]))
					{
						$receive = Server::getInstance()->getPlayer($data[1]);
						if ($receive instanceof Player)
						{
							$player->sendMessage(ReefCoinClient::GOOD.TextFormat::GREEN.$data[1].TextFormat::RESET.'さんに'.$data[2].'coin送金しました');
							$receive->sendMessage(ReefCoinClient::GOOD.TextFormat::GREEN.$player->getName().TextFormat::RESET.'さんから'.$data[2].'coin送金されました');
						}else{
							$player->sendMessage(ReefCoinClient::GOOD.TextFormat::GRAY.$data[1].TextFormat::RESET.'さんに'.$data[2].'coin送金しました');
						}
					}else $player->sendMessage(ReefCoinClient::ERROR.'Unknown error');
				}else $player->sendForm(new ReefCoinPayForm('お金が足りません' ,$data[1]));
			}else $player->sendForm(new ReefCoinPayForm('プレイヤーが見つかりませんでした' ,$data[1]));
		}else{
			$receiveName = $this->names[$data[1]];
			if (ReefCoinAPI::isExists($receiveName))
			{
				if (ReefCoinAPI::getCoin($player->getName()) >= $data[2] and is_numeric($data[2]) and $data[2] >= 0)
				{
					if (ReefCoinAPI::payCoin($player->getName() ,$receiveName ,$data[2]))
					{
						$receive = Server::getInstance()->getPlayer($receiveName);
						if ($receive instanceof Player)
						{
							$player->sendMessage(ReefCoinClient::GOOD.TextFormat::GREEN.$receiveName.TextFormat::RESET.'さんに'.$data[2].'coin送金しました');
							$receive->sendMessage(ReefCoinClient::GOOD.TextFormat::GREEN.$player->getName().TextFormat::RESET.'さんから'.$data[2].'coin送金されました');
						}else{
							$player->sendMessage(ReefCoinClient::GOOD.TextFormat::GRAY.$receiveName.TextFormat::RESET.'さんに'.$data[2].'coin送金しました');
						}
					}else $player->sendMessage(ReefCoinClient::ERROR.'Unknown error');
				}else $player->sendForm(new ReefCoinPayForm('お金が足りません' ,$receiveName));
			}else $player->sendForm(new ReefCoinPayForm('プレイヤーが見つかりませんでした' ,$receiveName));
		}

	}

	/**
	 * @inheritDoc
	 */
	public function jsonSerialize()
	{
		$title = 'PaySystem for '.ReefCoinSystemCore::getCoreName();
		foreach (ReefCoinAPI::getAll() as $name)
		{
			if (strpos($name ,$this->nameParts) !== false)
			{
				$replace = str_replace($this->nameParts ,TextFormat::RED.$this->nameParts.TextFormat::RESET ,$name);
				$this->names[] = $name;
				$list[] = $replace;
			}
		}
		if ($this->nameParts and !empty($list))
		{
			return [
				'type' => 'custom_form',
				'title' => $title,
				'content' => [
					[
						'type' => 'label',
						'text' => $this->content,
					],
					[
						'type' => 'dropdown',
						'text' => $this->nameParts.'の検索結果です',
						'options' => $list,
					],
					[
						'type' => 'input',
						'text' => '送る金額を入力してください',
						'placeholder' => '数字',
						'default' => '',
					],
				]
			];
		}else{
			return [
				'type' => 'custom_form',
				'title' => $title,
				'content' => [
					[
						'type' => 'label',
						'text' => $this->content,
					],
					[
						'type' => 'input',
						'text' => '送るプレイヤーを入力してください',
						"placeholder" => "文字",
						'default' => '',
					],
					[
						'type' => 'input',
						'text' => '送る金額を入力してください',
						"placeholder" => "数字",
						'default' => '',
					],
				]
			];
		}

	}
}