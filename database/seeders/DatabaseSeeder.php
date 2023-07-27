<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\PostSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\PermissionSeeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            PostSeeder::class
        ]);

        // Clean Storage
        $photos = Storage::allFiles('public');
        array_shift($photos);
        Storage::delete($photos);

        $badgeText = "Database Seeding Successfully!";
        $seedlingIcon = "🌱 🌱 🌱 🌱 ";
        $paddingLength = 20;
        $centeredText = str_pad($badgeText, $paddingLength, " ", STR_PAD_BOTH);
        $marginLines = 3;
        $margin = str_repeat(PHP_EOL, $marginLines);
        $marginLeftSpaces = 2;
        $leftMargin = str_repeat(" ", $marginLeftSpaces);

        echo $margin;
        echo $leftMargin . "$seedlingIcon \033[1;36;1mWell Done! $centeredText $seedlingIcon ";
        echo $margin;
    }
}
