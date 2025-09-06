<?php

use Illuminate\Support\Facades\App;
use Mockery\MockInterface;
use Parfaitementweb\FilamentCountryField\Forms\Components\Country;

it('returns the country list by default', function () {
    $mock = $this->partialMock(Country::class, function (MockInterface $mock) {
        $mock->shouldReceive('getList')
            ->once()
            ->andReturn(['CA' => 'Canada', 'US' => 'United States']);
    });

    $options = $mock
        ->getOptions();

    expect($options)->toBe(['CA' => 'Canada', 'US' => 'United States']);
});

it('returns the options list if set', function () {
    $countryField = (new Country('country'))->options(['foo' => 'bar']);
    $options = $countryField
        ->getOptions();

    expect($options)->toBe(['foo' => 'bar']);
});

it('can add element with options', function () {
    $mock = $this->partialMock(Country::class, function (MockInterface $mock) {
        $mock->shouldReceive('getList')
            ->once()
            ->andReturn(['CA' => 'Canada', 'US' => 'United States']);
    });

    $options = $mock
        ->add(['MA' => 'Mars'])
        ->getOptions();

    expect($options)->toBe(['CA' => 'Canada', 'MA' => 'Mars', 'US' => 'United States']);
});

it('can exclude element with options', function () {
    $mock = $this->partialMock(Country::class, function (MockInterface $mock) {
        $mock->shouldReceive('getList')
            ->once()
            ->andReturn(['CA' => 'Canada', 'US' => 'United States']);
    });

    $options = $mock
        ->exclude(['CA'])
        ->getOptions();

    expect($options)->toBe(['US' => 'United States']);
});

it('can map element keys with options', function () {
    $mock = $this->partialMock(Country::class, function (MockInterface $mock) {
        $mock->shouldReceive('getList')
            ->once()
            ->andReturn(['CA' => 'Canada', 'US' => 'United States']);
    });

    $options = $mock
        ->map(['CA' => 'CN'])
        ->getOptions();

    expect($options)->toBe(['CN' => 'Canada', 'US' => 'United States']);
});

it('can map element keys with options as an array', function () {
    $mock = $this->partialMock(Country::class, function (MockInterface $mock) {
        $mock->shouldReceive('getList')
            ->once()
            ->andReturn(['CA' => 'Canada', 'US' => 'United States']);
    });

    $options = $mock
        ->map(['CA' => 'CN', 'US' => 'UN'])
        ->getOptions();

    expect($options)->toBe(['CN' => 'Canada', 'UN' => 'United States']);
});

it('returns options sorted by keys by default', function () {
    $mock = $this->partialMock(Country::class, function (MockInterface $mock) {
        $mock->shouldReceive('getList')
            ->once()
            ->andReturn(['US' => 'United States', 'CA' => 'Canada', 'BE' => 'Belgium']);
    });

    $options = $mock
        ->getOptions();

    expect($options)->toBe(['BE' => 'Belgium', 'CA' => 'Canada', 'US' => 'United States']);
});

it('returns options after exclude, add and map elements', function () {
    $mock = $this->partialMock(Country::class, function (MockInterface $mock) {
        $mock->shouldReceive('getList')
            ->once()
            ->andReturn(['US' => 'United States', 'CA' => 'Canada', 'BE' => 'Belgium']);
    });

    $options = $mock
        ->exclude(['CA'])
        ->add(['MA' => 'Mars'])
        ->map(['BE' => 'BN'])
        ->getOptions();

    expect($options)->toBe(['BN' => 'Belgium', 'MA' => 'Mars', 'US' => 'United States']);
});

it('ignores empty keys when map is called', function () {
    $mock = $this->partialMock(Country::class, function (MockInterface $mock) {
        $mock->shouldReceive('getList')
            ->once()
            ->andReturn(['US' => 'United States', 'CA' => 'Canada']);
    });

    $options = $mock
        ->map(['' => 'CN'])
        ->getOptions();

    expect($options)->toBe(['CA' => 'Canada', 'US' => 'United States']);
});

it('returns default options when methods are called with empty array', function () {
    $mock = $this->partialMock(Country::class, function (MockInterface $mock) {
        $mock->shouldReceive('getList')
            ->once()
            ->andReturn(['US' => 'United States', 'CA' => 'Canada']);
    });

    $options = $mock
        ->exclude([])
        ->add([])
        ->map([])
        ->getOptions();

    expect($options)->toBe(['CA' => 'Canada', 'US' => 'United States']);
});

it('gets the data from the correct file in English', function () {
    App::setLocale('en');
    $data = (new Country('country'))
        ->getList();

    expect($data)->toBe(require __DIR__ . "/../resources/lang/en/country.php");
});

it('gets the data from the correct file in French', function () {
    App::setLocale('fr');
    $data = (new Country('country'))
        ->getList();

    expect($data)->toBe(require __DIR__ . '/../resources/lang/fr/country.php');
});

it('gets the english version is current locale does not exist', function () {
    App::setLocale('unexistent');
    $data = (new Country('country'))
        ->getList();

    expect($data)->toBe(require __DIR__ . '/../resources/lang/en/country.php');
});

it('gets the simplified version of the locale name', function () {
    App::setLocale('fr_BE');

    $data = (new Country('country'))
        ->getList();

    expect($data)->toBe(require __DIR__ . '/../resources/lang/fr/country.php');
});

it('can filter to only show specific countries', function () {
    $mock = $this->partialMock(Country::class, function (MockInterface $mock) {
        $mock->shouldReceive('getList')
            ->once()
            ->andReturn(['US' => 'United States', 'CA' => 'Canada', 'BE' => 'Belgium']);
    });

    $options = $mock
        ->only(['US', 'CA'])
        ->getOptions();

    expect($options)->toBe(['CA' => 'Canada', 'US' => 'United States']);
});

it('shows all countries when only() is called with an empty array', function () {
    $mock = $this->partialMock(Country::class, function (MockInterface $mock) {
        $mock->shouldReceive('getList')
            ->once()
            ->andReturn(['US' => 'United States', 'CA' => 'Canada', 'BE' => 'Belgium']);
    });

    $options = $mock
        ->only([])
        ->getOptions();

    expect($options)->toBe(['BE' => 'Belgium', 'CA' => 'Canada', 'US' => 'United States']);
});

it('shows all countries when only() is passed non-existent country codes', function () {
    $mock = $this->partialMock(Country::class, function (MockInterface $mock) {
        $mock->shouldReceive('getList')
            ->once()
            ->andReturn(['US' => 'United States', 'CA' => 'Canada', 'BE' => 'Belgium']);
    });

    $options = $mock
        ->only(['XX', 'YY'])
        ->getOptions();

    expect($options)->toBe(['BE' => 'Belgium', 'CA' => 'Canada', 'US' => 'United States']);
});

it('correctly combines only() with exclude() to filter countries', function () {
    $mock = $this->partialMock(Country::class, function (MockInterface $mock) {
        $mock->shouldReceive('getList')
            ->once()
            ->andReturn(['US' => 'United States', 'CA' => 'Canada', 'BE' => 'Belgium', 'FR' => 'France']);
    });

    $options = $mock
        ->only(['US', 'CA', 'BE'])
        ->exclude(['BE'])
        ->getOptions();

    expect($options)->toBe(['CA' => 'Canada', 'US' => 'United States']);
});

it('returns filtered options after only(), exclude(), add() and map() operations', function () {
    $mock = $this->partialMock(Country::class, function (MockInterface $mock) {
        $mock->shouldReceive('getList')
            ->once()
            ->andReturn(['US' => 'United States', 'CA' => 'Canada', 'BE' => 'Belgium', 'FR' => 'France']);
    });

    $options = $mock
        ->only(['US', 'CA', 'BE'])
        ->exclude(['BE'])
        ->add(['MA' => 'Mars'])
        ->map(['US' => 'UN'])
        ->getOptions();

    expect($options)->toBe(['CA' => 'Canada', 'MA' => 'Mars', 'UN' => 'United States']);
});

it('can filter valid countries when only() contains a mix of valid and invalid codes', function () {
    $mock = $this->partialMock(Country::class, function (MockInterface $mock) {
        $mock->shouldReceive('getList')
            ->once()
            ->andReturn(['US' => 'United States', 'CA' => 'Canada', 'BE' => 'Belgium']);
    });

    $options = $mock
        ->only(['US', 'XX'])
        ->getOptions();

    expect($options)->toBe(['US' => 'United States']);
});