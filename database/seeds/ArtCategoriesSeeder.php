<?php

use Illuminate\Database\Seeder;

class ArtCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('art_categories')->insert([
            // Seeding objectives for all Art Categories    
            [
                'alias'    => 'asbstraction',
                'name'    => 'Абстракция',
                'active'    => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'alias'    => 'artdeco',
                'name'    => 'Арт-деко',
                'active'    => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'alias'    => 'dadaism',
                'name'    => 'Дадаизм',
                'active'    => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'alias'    => 'impressionism',
                'name'    => 'Импрессионизм',
                'active'    => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'alias'    => 'сonceptualism',
                'name'    => 'Концептуализм',
                'active'    => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'alias'    => 'cubism',
                'name'    => 'Концептуализм',
                'active'    => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'alias'    => 'minimalism',
                'name'    => 'Минимализм',
                'active'    => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'alias'    => 'modern',
                'name'    => 'Модерн',
                'active'    => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'alias'    => 'country',
                'name'    => 'Народный стиль',
                'active'    => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'alias'    => 'popart',
                'name'    => 'Поп-арт',
                'active'    => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'alias'    => 'realism',
                'name'    => 'Реализм',
                'active'    => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'alias'    => 'surrealism',
                'name'    => 'Сюрреализм',
                'active'    => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'alias'    => 'street',
                'name'    => 'Уличный',
                'active'    => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'alias'    => 'figure',
                'name'    => 'Фигуративный стиль',
                'active'    => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'alias'    => 'expressionism',
                'name'    => 'Экспрессионизм',
                'active'    => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ]);
    }
}
