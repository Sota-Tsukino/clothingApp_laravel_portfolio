<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            PrefectureSeeder::class,
            CitySeeder::class,
            UserSeeder::class,
            BodyMeasurementSeeder::class,
            BodyCorrectionSeeder::class,
            FittingTolerance::class,
            BrandSeeder::class,
            CategorySeeder::class,
            ColorSeeder::class,
            MaterialSeeder::class,
            SeasonSeeder::class,
            SubCategorySeeder::class,
            TagSeeder::class,
            SceneTagSeeder::class,
            WeatherTypeSeeder::class,
            ImageSeeder::class,
            ItemSeeder::class,
        ]);

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
