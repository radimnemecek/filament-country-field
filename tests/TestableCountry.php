<?php

namespace Parfaitementweb\FilamentCountryField\Tests;

use Parfaitementweb\FilamentCountryField\Forms\Components\Country;

class TestableCountry extends Country
{
    protected ?array $testCountries = null;

    public function setTestCountries(array $countries): static
    {
        $this->testCountries = $countries;

        return $this;
    }

    public function getList(): array
    {
        return $this->testCountries ?? parent::getList();
    }
}
