<?php

namespace Omega892\AP;

use Omega892\AP\Commands\ApsCommand;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;

class Main extends PluginBase {

    public static Config $config;
    public function onEnable(): void
    {
        $this->getServer()->getCommandMap()->register("ap", new ApsCommand($this));

        self::$config = new Config($this->getDataFolder() . "config.yml", Config::YAML);
        $this->saveDefaultConfig();
    }
}