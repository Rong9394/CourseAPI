<?php

namespace App\OpenApi\Parameters;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\ParametersFactory;

class InsertUpdateCourseParameters extends ParametersFactory
{
    /**
     * @return Parameter[]
     */
    public function build(): array
    {
        return [

            Parameter::query()
                ->name('title')
                ->description('Title of the course')
                ->required(true)
                ->schema(Schema::string()),

            Parameter::query()
                ->name('description')
                ->description('Description of the course')
                ->required(true)
                ->schema(Schema::string()),
            
            Parameter::query()
                ->name('price_in_cents_usd')
                ->description('Price in US cents of the course')
                ->required(true)
                ->schema(Schema::integer()),
        ];
    }
}
