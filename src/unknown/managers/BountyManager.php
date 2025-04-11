<?php

namespace unknown\managers;

use pocketmine\player\Player;
use pocketmine\utils\Config;
use unknown\Bounty;
use unknown\Loader;

class BountyManager extends Bounty
{
    public array $bountySe = [];
    public array $bounty = [];
    private Config $config;

    public function __construct()
    {
        $this->config = new Config(Loader::getInstance()->getDataFolder() . "bounty.json", Config::JSON);
        $this->load();
    }

    public function getBounty(Player $target): Bounty
    {
        if (isset($this->bounty[$target->getName()])) {
            $player = $this->bounty[$target->getName()]["player"] ?? "Unknown";
            $amount = $this->bounty[$target->getName()]["amount"] ?? 0;
                return new Bounty($player, $target, $this->bounty[$target->getName()]["amount"]);
        }
        return new Bounty($target, $target, 0);
    }

    public function load(): void
    {
        $this->bounty = $this->config->get("bounty");
    }

    public function addBounty(Player $player, Player $target, int $amount): void
    {
        $this->bounty[$target->getName()] = [
            "player" => $player->getName(),
            "amount" => $amount
        ];
        $this->save();
    }

    public function removeBounty(Player $player): void
    {
        unset($this->bounty[$player->getName()]);
    }

    public function getBountty(Player $player, string $value): array
    {
        if (isset($this->bounty[$player->getName()])) {
            return $this->bounty[$player->getName()][$value];
        }
        return [];
    }

    public function getBountys(): array
    {
        return $this->bounty;
    }

    public function save(): void
    {
        $this->config->set("bounty", $this->bounty);
        $this->config->save();
    }
}