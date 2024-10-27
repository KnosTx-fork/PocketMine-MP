<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
 */

declare(strict_types=1);

namespace pocketmine\command;

use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use function count;
use function strtolower;

class WeatherCommand extends Command {

	public function __construct() {
		parent::__construct("weather",
		"Changing the weather in the world",
		"/weather <type> [duration]");
		$this->setPermission(DefaultPermissionNames::COMMAND_WEATHER);
	}

	public function execute(CommandSender $sender, string $commandLabel, array $args) : bool {
		if (!$this->testPermission($sender)) {
			$sender->sendMessage(TextFormat::RED . "You don't have permission to use this command");
			return false;
		}

		if (count($args) < 1) {
			$sender->sendMessage(TextFormat::RED . "Usage: /weather <type> [duration]");
			return false;
		}

		if (!$sender instanceof Player) {
			$sender->sendMessage(TextFormat::RED . "Hanya pemain yang bisa menggunakan perintah ini.");
			return false;
		}

		$world = $sender->getWorld();
		$weatherManager = $world->getWeatherManager();

		switch (strtolower($args[0])) {
			case "clear":
				$weatherManager->setClear();
				$sender->sendMessage(TextFormat::GREEN . "Cuaca diubah menjadi cerah.");
				break;

			case "rain":
				$weatherManager->setRain();
				$sender->sendMessage(TextFormat::GREEN . "Cuaca diubah menjadi hujan.");
				break;

			case "thunder":
				$weatherManager->setThunder();
				$sender->sendMessage(TextFormat::GREEN . "Cuaca diubah menjadi badai petir.");
				break;

			default:
				$sender->sendMessage(TextFormat::RED . "Jenis cuaca tidak valid! Gunakan: clear, rain, atau thunder.");
				return false;
		}

		return true;
	}
}
