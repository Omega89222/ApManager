<?php

namespace Omega892\AP\Commands\subCommand;

use CortexPE\Commando\args\RawStringArgument;
use CortexPE\Commando\BaseSubCommand;
use CortexPE\Commando\constraint\InGameRequiredConstraint;
use Omega892\AP\Main;
use Omega892\CustomItem\CustomItem;
use pocketmine\command\CommandSender;

final class SetApCommand extends BaseSubCommand {

    public function __construct(private Main $plugin){
        parent::__construct("set", "Set a new ap");
        $this->setPermission("ap.use");
    }

    protected function prepare(): void {
        $this->addConstraint(new InGameRequiredConstraint($this));
        $this->registerArgument(0, new RawStringArgument("apName"));
    }

    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void {
        $config = Main::$config;
        $apName = $args["apName"];
        $apNameAvaible = ["north", "south", "east", "west"];
        if (!in_array($apName, $apNameAvaible)) {
            $sender->sendMessage("§cVous need choose a valid ap.");
            return;
        }

        $pos = $sender->getPosition();
        $worldName = $pos->getWorld()->getFolderName();

        $config->setNested("aps." . $apName, [
            "x" => $pos->getX(),
            "y" => $pos->getY(),
            "z" => $pos->getZ(),
            "world" => $worldName
        ]);
        $config->save();
        $sender->sendMessage("§aAP §e{$apName} §ahas been set at your current location.");
    }
}
