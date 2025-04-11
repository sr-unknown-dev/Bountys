<?php

namespace unknown;

use pocketmine\player\Player;

class Bounty
{

    public string $target;
    public int $amount;
    public string $player;
    private array $bountySe = [];

    public function __construct(string $player, string $target, int $amount)
    {
        $this->player = $player;
        $this->target = $target;
        $this->amount = $amount;
    }

    public function getTarget(Player $player): ?string
    {
        return $this->target;
    }
    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function getPlayer(): ?string
    {
        return $this->player;
    }

    public function addtBountySe(): void
    {
        $this->bountySe[$this->player] = $this->target;
    }

    public function removeBountySe(): void
    {
        unset($this->bountySe[$this->player]);
    }

    public function isBountySe(): bool
    {
        return isset($this->bountySe[$this->player]);
    }
}