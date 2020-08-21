<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Contact;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Contact::class, function (Faker $faker, $option) {
    $extension = ['pdf','doc','docx','odt','txt'];
    $sizeMin = 50;
    $sizeMax = 500;
    
    if (isset($option['file']['type'])) {
        if ($option['file']['type'] == 'max') {
            $sizeMin = $option['file']['size']+10;
            $sizeMax = $option['file']['size']+20;
        } else if ($option['file']['type'] == 'mimes') {
            $extension = [$option['file']['extension']];
        }
    }

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'message' => $faker->name,
        'file' => UploadedFile::fake()->create('curriculum.'.$faker->randomElement($extension), $faker->numberBetween($sizeMin, $sizeMax)),
    ];
});
