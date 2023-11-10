<?php

namespace Database\Seeders;

use App\Models\Product;
use Faker\Provider\Image;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $faker->addProvider(new Image($faker));

        for ($i = 0; $i < 20; $i++) {
            $name = $faker->word;
            $description = $faker->paragraph;
            $price = $faker->numberBetween(10000, 100000);
            $stock = $faker->numberBetween(0, 100);
            $image = $faker->imageUrl(640, 480, 'cats', true, 'Faker');
            $slug = Str::slug($name, '-'); // Menggunakan fungsi Str::slug untuk menghasilkan slug dari nama

            // Check if the slug already exists, if it does, append a unique identifier
            $count = Product::where('slug', $slug)->count();
            if ($count > 0) {
                $slug = $slug . '-' . $count;
            }

            DB::table('products')->insert([
                'id' => Str::uuid(),
                'name' => $name,
                'description' => $description,
                'price' => $price,
                'stock' => $stock,
                'image' => $image,
                'slug' => $slug,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

    }
}