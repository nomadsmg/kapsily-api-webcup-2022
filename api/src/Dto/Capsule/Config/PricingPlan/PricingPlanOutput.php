<?php

namespace App\Dto\Capsule\Config\PricingPlan;

class PricingPlanOutput
{
    public string $uuid;
    public string $identifier;
    public string $label;
    public int $level;
    public string $description;
    public int $minds;
    public int $years;
    public array $offres;

    public function setUuid($uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function setIdentifier($identifier): self
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function setLabel($label): self
    {
        $this->label = $label;

        return $this;
    }

    public function setLevel($level): self
    {
        $this->level = $level;

        return $this;
    }

    public function setDescription($description): self
    {
        $this->description = $description;

        return $this;
    }

    public function setMinds($minds): self
    {
        $this->minds = $minds;

        return $this;
    }

    public function setYears($years): self
    {
        $this->years = $years;

        return $this;
    }

    public function setOffres($offres): self
    {
        $this->offres = $offres;

        return $this;
    }
}
