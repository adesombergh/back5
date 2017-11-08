<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    $faker->addProvider(new Faker\Provider\fr_FR\Person($faker));
    static $password;

    return [
        'name' => $faker->firstName,
        'username' => $faker->unique()->username,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Service::class, function (Faker\Generator $faker) {
    return [
        'qui' => function () {
            return factory(App\User::class)->create()->id;
        }
    ];
});

$factory->define(App\Bonus::class, function (Faker\Generator $faker) {
    return [
        'taille_equipe' => 0,
    ];
});

$factory->define(App\Caisse::class, function (Faker\Generator $faker) {
    return [
        'service_id' => 1,
    ];
});

$factory->define(App\Sortie::class, function (Faker\Generator $faker) {
    return [
        'type' => $faker->randomElement(['avance','dj','courses','autre']),
        'desc' => $faker->sentence($nbWords = 3),
        'value' => $faker->randomFloat(2,0,100),
        'facture' => $faker->boolean(20),
        'qui' => null
    ];
});

$factory->define(App\Entree::class, function (Faker\Generator $faker) {
    return [
        'value' => $faker->randomFloat(2,0,100),
    ];
});

$factory->define(App\Comment::class, function (Faker\Generator $faker) {
    return [
        'type' => \App\CommentType::all()->random()->id,
        'content' => $faker->paragraph,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
    ];
});

$factory->define(App\Horaire::class, function (Faker\Generator $faker) {
    $factory = array(
        'user_id' => \App\User::all()->random()->id,
        'heures' => mt_rand(5/0.25,12/0.25)*0.25,
        
    );
    // if ( $faker->boolean(10) ) {
    //     $factory['bonus'] = mt_rand(2/0.25,4/0.25)*0.25;
    // };
    return $factory;
});


