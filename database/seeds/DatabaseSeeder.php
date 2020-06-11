<?php

use Illuminate\Database\Seeder;
use App\User;
use App\UserType;
use App\LedgerHead;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UserSeeder::class);
         $this->call(PagesSeeder::class);
    }
}