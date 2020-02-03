<?php


namespace ree\sub\client\command;


use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use ree\coin\ReefCoinAPI;
use ree\sub\client\form\ReefCoinPayForm;
use ree\sub\client\ReefCoinClient;

class PayCommand extends Command
{
	public function __construct(string $name = 'pay', string $description = 'PayCommandForReefCoinSystem', string $usageMessage = null, array $aliases = [], ?array $overloads = null)
	{
		parent::__construct($name, $description, $usageMessage, $aliases, $overloads);
		$this->setPermissionMessage(TextFormat::RED . 'Set permissions from \'plugin.yml\' to \'true\' to allow use without permissions');
		$this->setPermission('command.reefcoin.pay');
		$this->setDescription($description);
	}

	/**
	 * @inheritDoc
	 */
	public function execute(CommandSender $sender, string $commandLabel, array $args)
	{
		if (!$this->testPermission($sender)) {
			return false;
		}
		if (!$sender instanceof Player) {
			$sender->sendMessage(ReefCoinClient::ERROR . 'Please run this command in-game');
			return true;
		}
		if (count($args) === 2) {
			if (ReefCoinAPI::isExists($args[0])) {
				if (ReefCoinAPI::getCoin($args[0]) >= $args[1] and is_numeric($args[1])) {
					if (ReefCoinAPI::payCoin($sender->getName(), $args[0], $args[1])) {
						$receive = Server::getInstance()->getPlayer($args[0]);
						if ($receive instanceof Player) {
							$sender->sendMessage(ReefCoinClient::GOOD . TextFormat::GREEN . $args[0] . TextFormat::RESET . 'さんに' . $args[1] . 'coin送金しました');
							$receive->sendMessage(ReefCoinClient::GOOD . TextFormat::GREEN . $sender->getName() . TextFormat::RESET . 'さんから' . $args[1] . 'coin送金されました');
						} else {
							$sender->sendMessage(ReefCoinClient::GOOD . TextFormat::GRAY . $args[0] . TextFormat::RESET . 'さんに' . $args[1] . 'coin送金しました');
						}
					} else {
						$sender->sendMessage(ReefCoinClient::ERROR . 'Unknown error');
					}
				} else {
					$sender->sendForm(new ReefCoinPayForm('お金が足りません', $args[0]));
				}
			} else {
				$sender->sendForm(new ReefCoinPayForm('見つかりませんでした', $args[0]));
			}
		} else {
			if (empty($args)) {
				$sender->sendForm(new ReefCoinPayForm());
			} else {
				$sender->sendForm(new ReefCoinPayForm('コマンドが間違っています'));
			}
		}
		return true;
	}
}