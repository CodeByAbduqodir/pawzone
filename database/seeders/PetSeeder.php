<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Database\Seeder;

class PetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::query()->pluck('id', 'slug');
        $users = User::query()->pluck('id', 'email');

        $pets = [
            [
                'user_email' => 'admin@pawzone.local',
                'category' => 'mushuklar',
                'type' => 'lost',
                'name' => 'Britaniya mushugi',
                'description' => 'Ko‘k ko‘zli, sokin xarakterli britaniya mushugi. Yelvizakdan qo‘rqadi va uyga o‘rganib qolgan.',
                'phone' => '+998901100001',
                'telegram' => '@pawzone_admin',
                'location' => 'Toshkent, Yunusobod',
                'incident_date' => now()->subDays(4),
                'status' => 'available',
                'image' => 'images/pets/british-cat.jpg',
            ],
            [
                'user_email' => 'owner@pawzone.local',
                'category' => 'mushuklar',
                'type' => 'found',
                'name' => 'Meyn-kun mushugi',
                'description' => 'Katta gavdali, juda do‘stona meyn-kun mushugi. Hozircha vaqtincha qarovda.',
                'phone' => '+998901100002',
                'telegram' => '@pawzone_owner',
                'location' => 'Toshkent, Chilonzor',
                'incident_date' => now()->subDays(6),
                'status' => 'pending',
                'image' => 'images/pets/maine-coon.jpg',
            ],
            [
                'user_email' => 'finder@pawzone.local',
                'category' => 'mushuklar',
                'type' => 'lost',
                'name' => 'Sfinks mushugi',
                'description' => 'Junisiz sfinks mushugi. Ismi chalinganda keladi, juda mehribon.',
                'phone' => '+998901100003',
                'telegram' => '@pawzone_finder',
                'location' => 'Toshkent, Mirzo Ulug‘bek',
                'incident_date' => now()->subDays(8),
                'status' => 'resolved',
                'image' => 'images/pets/sphynx.jpg',
            ],
            [
                'user_email' => 'admin@pawzone.local',
                'category' => 'mushuklar',
                'type' => 'found',
                'name' => 'Bengal mushugi',
                'description' => 'Faol va o‘ynoqi bengal mushugi. Juda chaqqon, diqqat bilan qarash kerak.',
                'phone' => '+998901100004',
                'telegram' => null,
                'location' => 'Toshkent, Sergeli',
                'incident_date' => now()->subDays(2),
                'status' => 'available',
                'image' => 'images/pets/british-cat.jpg',
            ],
            [
                'user_email' => 'owner@pawzone.local',
                'category' => 'mushuklar',
                'type' => 'lost',
                'name' => 'Scottish Fold',
                'description' => 'Buralgan quloqli shotland mushugi. Tinch va bolalarga o‘rgangan.',
                'phone' => '+998901100005',
                'telegram' => '@scottish_fold_demo',
                'location' => 'Toshkent, Olmazor',
                'incident_date' => now()->subDays(1),
                'status' => 'available',
                'image' => 'images/pets/maine-coon.jpg',
            ],
            [
                'user_email' => 'finder@pawzone.local',
                'category' => 'itlar',
                'type' => 'lost',
                'name' => 'Labrador kuchukchasi',
                'description' => 'Mehribon va sodiq labrador kuchukchasi. Bog‘ sayrlarini yaxshi ko‘radi.',
                'phone' => '+998901100006',
                'telegram' => '@labrador_demo',
                'location' => 'Toshkent, Yashnobod',
                'incident_date' => now()->subDays(3),
                'status' => 'available',
                'image' => 'images/pets/labrador.jpg',
            ],
            [
                'user_email' => 'admin@pawzone.local',
                'category' => 'itlar',
                'type' => 'found',
                'name' => 'Nemis cho‘poni',
                'description' => 'Aqlli va hushyor nemis cho‘poni. Ajoyib qo‘riqchi bo‘la oladi.',
                'phone' => '+998901100007',
                'telegram' => '@german_shepherd_demo',
                'location' => 'Toshkent, Shayxontohur',
                'incident_date' => now()->subDays(7),
                'status' => 'pending',
                'image' => 'images/pets/german-shepherd.jpg',
            ],
            [
                'user_email' => 'owner@pawzone.local',
                'category' => 'itlar',
                'type' => 'lost',
                'name' => 'Xaski',
                'description' => 'Energiya to‘la xaski. Kuniga uzoq yurish va faol o‘yin kerak.',
                'phone' => '+998901100008',
                'telegram' => '@husky_demo',
                'location' => 'Toshkent, Bektemir',
                'incident_date' => now()->subDays(5),
                'status' => 'available',
                'image' => 'images/pets/husky.jpg',
            ],
            [
                'user_email' => 'finder@pawzone.local',
                'category' => 'itlar',
                'type' => 'found',
                'name' => 'Yorkshir terer',
                'description' => 'Kichkina, nafis va juda chaqqon yorkshir terer. Kvartira uchun mos.',
                'phone' => '+998901100009',
                'telegram' => null,
                'location' => 'Toshkent, Uchtepa',
                'incident_date' => now()->subDays(9),
                'status' => 'resolved',
                'image' => 'images/pets/yorkie.jpg',
            ],
            [
                'user_email' => 'admin@pawzone.local',
                'category' => 'itlar',
                'type' => 'found',
                'name' => 'Golden retriver',
                'description' => 'Yaxshi kayfiyatli, oson o‘rgatiladigan retriver. A’lo oilaviy hamroh.',
                'phone' => '+998901100010',
                'telegram' => '@golden_demo',
                'location' => 'Toshkent, Mirobod',
                'incident_date' => now()->subDays(12),
                'status' => 'available',
                'image' => 'images/pets/labrador.jpg',
            ],
            [
                'user_email' => 'owner@pawzone.local',
                'category' => 'qushlar',
                'type' => 'lost',
                'name' => 'To‘lqinsimon to‘tiqush',
                'description' => 'Rang-barang va juda qiziquvchan to‘lqinsimon to‘tiqush. Tez gapirishni o‘rganadi.',
                'phone' => '+998901100011',
                'telegram' => '@budgie_demo',
                'location' => 'Toshkent, Yunusobod',
                'incident_date' => now()->subDays(2),
                'status' => 'available',
                'image' => 'images/pets/budgie.jpg',
            ],
            [
                'user_email' => 'finder@pawzone.local',
                'category' => 'qushlar',
                'type' => 'found',
                'name' => 'Korella to‘tiqushi',
                'description' => 'Sokin va hamrohga oson o‘rganadigan korella to‘tiqushi. Kuylarni yaxshi ko‘radi.',
                'phone' => '+998901100012',
                'telegram' => '@cockatiel_demo',
                'location' => 'Toshkent, Chilonzor',
                'incident_date' => now()->subDays(4),
                'status' => 'pending',
                'image' => 'images/pets/cockatiel.jpg',
            ],
            [
                'user_email' => 'admin@pawzone.local',
                'category' => 'qushlar',
                'type' => 'lost',
                'name' => 'Kanareyka',
                'description' => 'Chiroyli sayrovchi kanareyka. Ertalab tinch ovozda sayraydi.',
                'phone' => '+998901100013',
                'telegram' => null,
                'location' => 'Toshkent, Sergeli',
                'incident_date' => now()->subDays(10),
                'status' => 'resolved',
                'image' => 'images/pets/canary.jpg',
            ],
            [
                'user_email' => 'owner@pawzone.local',
                'category' => 'qushlar',
                'type' => 'found',
                'name' => 'Ara to‘tiqushi',
                'description' => 'Katta va rangli ara to‘tiqushi. Juda aqlli va ovozini tez taniydi.',
                'phone' => '+998901100014',
                'telegram' => '@macaw_demo',
                'location' => 'Toshkent, Olmazor',
                'incident_date' => now()->subDays(14),
                'status' => 'available',
                'image' => 'images/pets/cockatiel.jpg',
            ],
            [
                'user_email' => 'finder@pawzone.local',
                'category' => 'baliqlar',
                'type' => 'found',
                'name' => 'Oltin baliq',
                'description' => 'Klassik oltin baliq. Akvarium uchun sodda va chiroyli variant.',
                'phone' => '+998901100015',
                'telegram' => '@goldfish_demo',
                'location' => 'Toshkent, Mirobod',
                'incident_date' => now()->subDays(1),
                'status' => 'available',
                'image' => 'images/pets/goldfish.jpg',
            ],
            [
                'user_email' => 'admin@pawzone.local',
                'category' => 'baliqlar',
                'type' => 'lost',
                'name' => 'Betta baliqi',
                'description' => 'Yorqin rangli betta baliqi. Yakka saqlash uchun qulay va chiroyli.',
                'phone' => '+998901100016',
                'telegram' => null,
                'location' => 'Toshkent, Yashnobod',
                'incident_date' => now()->subDays(3),
                'status' => 'pending',
                'image' => 'images/pets/betta.jpg',
            ],
            [
                'user_email' => 'owner@pawzone.local',
                'category' => 'baliqlar',
                'type' => 'found',
                'name' => 'Neon tetra',
                'description' => 'Kichik, ammo juda jozibali neon tetra. Suruvda yashashni yaxshi ko‘radi.',
                'phone' => '+998901100017',
                'telegram' => '@neon_tetra_demo',
                'location' => 'Toshkent, Uchtepa',
                'incident_date' => now()->subDays(6),
                'status' => 'available',
                'image' => 'images/pets/neon-tetra.jpg',
            ],
            [
                'user_email' => 'finder@pawzone.local',
                'category' => 'baliqlar',
                'type' => 'lost',
                'name' => 'Guppi juftligi',
                'description' => 'Rang-barang guppi juftligi. Faol va tez ko‘payadigan akvarium baliqlari.',
                'phone' => '+998901100018',
                'telegram' => '@guppy_demo',
                'location' => 'Toshkent, Bektemir',
                'incident_date' => now()->subDays(11),
                'status' => 'resolved',
                'image' => 'images/pets/guppy.jpg',
            ],
        ];

        foreach ($pets as $pet) {
            $categoryId = $categories[$pet['category']] ?? null;
            $userId = $users[$pet['user_email']] ?? null;

            if (! $categoryId || ! $userId) {
                continue;
            }

            Pet::updateOrCreate(
                [
                    'category_id' => $categoryId,
                    'name' => $pet['name'],
                ],
                [
                    'user_id' => $userId,
                    'type' => $pet['type'],
                    'description' => $pet['description'],
                    'phone' => $pet['phone'],
                    'telegram' => $pet['telegram'],
                    'location' => $pet['location'],
                    'incident_date' => $pet['incident_date'],
                    'image' => $pet['image'],
                    'status' => $pet['status'],
                ]
            );
        }
    }
}
