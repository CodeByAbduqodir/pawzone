<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Pet;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PetListingSeeder extends Seeder
{
    public function run(): void
    {
        // Очищаем таблицу pets
        Pet::truncate();

        // Создaём пользователей если их нет
        $admin = User::firstOrCreate(
            ['email' => 'admin@pawzone.local'],
            [
                'name'        => 'Admin',
                'password'    => Hash::make('password'),
                'role'        => 'admin',
                'is_verified' => true,
            ]
        );

        $user1 = User::firstOrCreate(
            ['email' => 'user1@example.com'],
            [
                'name'        => 'Фарход',
                'password'    => Hash::make('password'),
                'role'        => 'owner',
                'is_verified' => true,
            ]
        );

        $user2 = User::firstOrCreate(
            ['email' => 'user2@example.com'],
            [
                'name'        => 'Гавхар',
                'password'    => Hash::make('password'),
                'role'        => 'finder',
                'is_verified' => true,
            ]
        );

        $user3 = User::firstOrCreate(
            ['email' => 'user3@example.com'],
            [
                'name'        => 'Раҳим',
                'password'    => Hash::make('password'),
                'role'        => 'owner',
                'is_verified' => true,
            ]
        );

        // Категории
        $dogs  = Category::where('slug', 'itlar')->first();
        $cats  = Category::where('slug', 'mushuklar')->first();
        $birds = Category::where('slug', 'qushlar')->first();
        $fish  = Category::where('slug', 'baliqlar')->first();

        // Объявления — потерянные животные
        Pet::create([
            'user_id'       => $user1->id,
            'category_id'   => $dogs->id,
            'type'          => 'lost',
            'name'          => 'Макс',
            'description'   => 'Қоҳа рангида, 3 ёшли овчарка. Узунқўл қоименасида йўқолди.',
            'phone'         => '+998901234567',
            'location'      => 'Тошкент, Узунқўлский район',
            'incident_date' => now()->subDays(5),
            'status'        => 'available',
            'price'         => null,
        ]);

        Pet::create([
            'user_id'       => $user2->id,
            'category_id'   => $cats->id,
            'type'          => 'lost',
            'name'          => 'Снежок',
            'description'   => 'Оқ масоллаҳ мушук. Турфон саркўчасида йўқолди.',
            'phone'         => '+998902345678',
            'location'      => 'Тошкент, Турфон саркўча',
            'incident_date' => now()->subDays(3),
            'status'        => 'available',
            'price'         => null,
        ]);

        Pet::create([
            'user_id'       => $user3->id,
            'category_id'   => $birds->id,
            'type'          => 'lost',
            'name'          => 'Полвон',
            'description'   => 'Кўҳна андижонский попугай. Соҳибсиз орадан чиқиб кетди.',
            'phone'         => '+998903456789',
            'location'      => 'Тошкент, Мирзо Улуғбек район',
            'incident_date' => now()->subDays(2),
            'status'        => 'available',
            'price'         => null,
        ]);

        // Объявления — найденные животные
        Pet::create([
            'user_id'       => $user1->id,
            'category_id'   => $dogs->id,
            'type'          => 'found',
            'name'          => 'Қоҳинон (найден)',
            'description'   => 'Қоҳа рангида кичик сўпа. Мирзо Улуғбек район Орозон кўчасида топилди.',
            'phone'         => '+998901111111',
            'location'      => 'Тошкент, Мирзо Улуғбек район',
            'incident_date' => now()->subDays(1),
            'status'        => 'available',
            'price'         => null,
        ]);

        Pet::create([
            'user_id'       => $user2->id,
            'category_id'   => $cats->id,
            'type'          => 'found',
            'name'          => 'Ҳусни (найдена)',
            'description'   => 'Қоҳа-оқ мушук, 2 ёшли. Қарши кўчасида топилди.',
            'phone'         => '+998902222222',
            'location'      => 'Тошкент, Қоршираҳ район',
            'incident_date' => now()->subDays(7),
            'status'        => 'pending',
            'price'         => null,
        ]);

        Pet::create([
            'user_id'       => $user3->id,
            'category_id'   => $fish->id,
            'type'          => 'found',
            'name'          => 'Балиқчик (найден)',
            'description'   => 'Сўрғилимон хвост билан балиқ. Боғ паркида дарёда топилди.',
            'phone'         => '+998903333333',
            'location'      => 'Тошкент, Боғ мегапарк',
            'incident_date' => now()->subDays(10),
            'status'        => 'sold',
            'price'         => null,
        ]);

        // Еще несколько закрытых объявлений
        Pet::create([
            'user_id'       => $admin->id,
            'category_id'   => $dogs->id,
            'type'          => 'lost',
            'name'          => 'Булан',
            'description'   => 'Қоҳ рангида питбуль. Узунқўл қўчасида йўқолди.',
            'phone'         => '+998909999999',
            'location'      => 'Тошкент, Узунқўл район',
            'incident_date' => now()->subDays(30),
            'status'        => 'sold',
            'price'         => null,
        ]);

        $this->command->info('✅ Фейковые объявления созданы успешно!');
    }
}

