<?php

namespace Omega892\AP\Commands;

use CortexPE\Commando\BaseCommand;
use CortexPE\Commando\BaseSubCommand;
use Omega892\AP\Commands\subCommand\SetApCommand;
use Omega892\AP\Commands\subCommand\TPApCommand;
use Omega892\AP\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

class ApsCommand extends BaseCommand {

    public function __construct(private Main $plugin)
    {
        parent::__construct($plugin, "ap", "Aps Commands");
        $this->setAliases([]);
        $this->setPermission("ap.use");
        $this->setPermissionMessage("§cYou don't have permission to use this command");
    }

    public function prepare(): void {
        $this->registerSubCommand(new SetApCommand($this->plugin));
        $this->registerSubCommand(new TPApCommand($this->plugin));
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        $sender->sendMessage("§cNo subcommand provided, try using: /" . $aliasUsed . " help");
    }

    public function getPermission(): ?string
    {
        return "ap.use";
    }
}