<?php

use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //10個のダミーデータを生成
        // factory(App\Post::class, 10)->create()->each(function($post){
        //     //3~15個のダミーデータを生成
        //     $post->comments()->saveMany(
        //         factory(App\Comment::class, mt_rand(3, 15))->make([
        //             'post_id' => null,
        //         ])
        //     );
        // });

        //10個のダミーデータを生成
        factory(App\Category::class, 2)->create()->each(function ($category) {
            //3~15個のダミーデータを生成
            $category->posts()->saveMany(
                factory(App\Post::class, 10)->make(['cat_id' => null])
            )->each(function($post) {
                //3~15個のダミーデータを生成
                $post->comments()->saveMany(
                    factory(App\Comment::class, mt_rand(3, 15))->make(['post_id' => null,])
                );
            });
        });
    }
}
