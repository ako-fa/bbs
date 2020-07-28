<?php

use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker) {
    return [
        //
        'title' => $faker->sentence,
        'content' => $faker->paragraph,
        'cat_id' => function(){
            return factory(App\Category::class)->create()->id;
        },
        // ファクトリーの中でカウントできないので仮のカウント数
        'comment_count' => '1'
    ];
});
