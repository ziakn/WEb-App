<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pages')->insert(
            [
                'user_role' => 1,
                'production_overview' => 1,
                'manage_user' =>1,
                'checklist_or_create' => 1,
                'scan_or_document' =>1,
                'setting' => 1,
            ],
        );
    }
}
