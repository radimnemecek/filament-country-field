<?php

namespace Parfaitementweb\FilamentCountryField\Tables\Columns;

use Filament\Tables\Columns\TextColumn;
use Parfaitementweb\FilamentCountryField\Traits\HasData;

class CountryColumn extends TextColumn
{
    use HasData;

    public function formatState(mixed $state): mixed
    {
        $countries = $this->getCountriesList();

        return $countries[$state] ?? $state;
    }
}
