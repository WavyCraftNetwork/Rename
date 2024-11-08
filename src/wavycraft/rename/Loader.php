<?php

declare(strict_types=1);

namespace wavycraft\rename;

use pocketmine\plugin\PluginBase;

final class Loader extends PluginBase {

    protected function onEnable() : void{
        $this->getServer()->getCommandMap()->register("Rename", new RenameCommand());
    }
}