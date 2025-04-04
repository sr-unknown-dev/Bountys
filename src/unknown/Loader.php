<?php

namespace unknown;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use unknown\managers\BountyManager;

class Loader extends PluginBase
{
    use SingletonTrait;
    public BountyManager $bountyManager;

    protected function onLoad(): void
    {
        self::setInstance($this);
    }

    protected function onEnable(): void
    {
        $this->bountyManager = new BountyManager();
    }

    /**
     * @return BountyManager
     */
    public function getBountyManager(): BountyManager
    {
        return $this->bountyManager;
    }
}