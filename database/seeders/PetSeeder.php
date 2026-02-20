<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Pet;
use Illuminate\Database\Seeder;

class PetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mushuklar = Category::where('slug', 'mushuklar')->first();
        $itlar = Category::where('slug', 'itlar')->first();
        $qushlar = Category::where('slug', 'qushlar')->first();
        $baliqlar = Category::where('slug', 'baliqlar')->first();

        $mushukPets = [
            [
                'name' => 'Britaniya mushugi',
                'price' => 1500000.00,
                'description' => 'Ko\'k ko\'zli go\'zal britaniya mushukchasi. Yoshi 3 oy, toza va o\'rgatilgan.',
                'image' => 'images/pets/british-cat.jpg',
                'status' => 'available',
            ],
            [
                'name' => 'Meyn-kun mushugi',
                'price' => 2500000.00,
                'description' => 'Katta va chiroyli Meyn-kun zoti. Do\'stona va o\'ynoqi.',
                'image' => 'images/pets/maine-coon.jpg',
                'status' => 'available',
            ],
            [
                'name' => 'Sfinks mushugi',
                'price' => 2000000.00,
                'description' => 'Jun yoq sfinks zoti mushukchasi. Juda mehr-oqibatli va uyqoqi.',
                'image' => 'images/pets/sphynx.jpg',
                'status' => 'sold',
            ],
        ];

        foreach ($mushukPets as $pet) {
            Pet::create(array_merge($pet, ['category_id' => $mushuklar->id]));
        }

        $itPets = [
            [
                'name' => 'Labrador kuchukchasi',
                'price' => 3000000.00,
                'description' => 'Aqlli va do\'stona labrador kuchukchasi. Bolalar bilan juda yaxshi til topadi.',
                'image' => 'images/pets/labrador.jpg',
                'status' => 'available',
            ],
            [
                'name' => 'Nemis cho\'poni',
                'price' => 3500000.00,
                'description' => 'Zotli nemis cho\'pon iti. A\'lo qo\'riqchi va hamroh.',
                'image' => 'images/pets/german-shepherd.jpg',
                'status' => 'available',
            ],
            [
                'name' => 'Xaski',
                'price' => 2800000.00,
                'description' => 'Ko\'k ko\'zli energik xaski kuchukchasi. Faol sayrlar talab qiladi.',
                'image' => 'images/pets/husky.jpg',
                'status' => 'available',
            ],
            [
                'name' => 'Yorkshir terer',
                'price' => 2200000.00,
                'description' => 'Kichkina yorkshir teryer. Kvartira uchun ideal, mehribon va o\'ynoqi.',
                'image' => 'images/pets/yorkie.jpg',
                'status' => 'sold',
            ],
        ];

        foreach ($itPets as $pet) {
            Pet::create(array_merge($pet, ['category_id' => $itlar->id]));
        }

        $qushPets = [
            [
                'name' => 'To\'lqinsimon to\'tiqush',
                'price' => 150000.00,
                'description' => 'Rang-barang to\'lqinsimon to\'tiqush. Tez o\'rganadi va gapira oladi.',
                'image' => 'images/pets/budgie.jpg',
                'status' => 'available',
            ],
            [
                'name' => 'Korella to\'tiqushi',
                'price' => 350000.00,
                'description' => 'Jufti bor korella to\'tiqushi. Juda suhbatdosh va musiqiy.',
                'image' => 'images/pets/cockatiel.jpg',
                'status' => 'available',
            ],
            [
                'name' => 'Kanareyka qushi',
                'price' => 250000.00,
                'description' => 'Sariqlash rangdagi sayrashi chiroyli kanareyka.',
                'image' => 'images/pets/canary.jpg',
                'status' => 'available',
            ],
        ];

        foreach ($qushPets as $pet) {
            Pet::create(array_merge($pet, ['category_id' => $qushlar->id]));
        }

        $baliqPets = [
            [
                'name' => 'Oltin baliq',
                'price' => 50000,
                'description' => 'Klassik oltin baliq. Parvarishi oson.',
                'image' => 'images/pets/goldfish.jpg',
                'status' => 'available',
            ],
            [
                'name' => 'Betta baliqi (Petushok)',
                'price' => 80000,
                'description' => 'Go\'zal qanotlari bor yorqin ko\'k rangdagi jangchi baliqi.',
                'image' => 'images/pets/betta.jpg',
                'status' => 'available',
            ],
            [
                'name' => 'Neon tetra (10 dona)',
                'price' => 120000,
                'description' => '10 dona neon tetra baliqlari. Neon chizig\'i bor chiroyli kichik baliqlar.',
                'image' => 'images/pets/neon-tetra.jpg',
                'status' => 'available',
            ],
            [
                'name' => 'Guppi (juft)',
                'price' => 60000,
                'description' => 'Rang-barang guppi juftligi. Oson ko\'payadi.',
                'image' => 'images/pets/guppy.jpg',
                'status' => 'sold',
            ],
        ];

        foreach ($baliqPets as $pet) {
            Pet::create(array_merge($pet, ['category_id' => $baliqlar->id]));
        }
    }
}
