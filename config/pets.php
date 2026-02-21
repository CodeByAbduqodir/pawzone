<?php

return [
    /**
     * Максимальное количество активных объявлений на пользователя
     */
    'max_listings_per_user' => 5,

    /**
     * Максимальное количество объявлений на пользователя в день
     */
    'max_listings_per_day' => 3,

    /**
     * Разрешённые регионы (если null, то регионы не ограничены)
     */
    'allowed_regions' => null, // ['Toshkent', 'Tashkent', 'Andijon', 'Bukhara', ...]
];
