<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::statement('SET FOREIGN_KEY_CHECKS = 0');
      App\Models\UserModel::truncate();
      factory(App\Models\UserModel::class, 3)->create();
      App\Models\PostModel::truncate();
      factory(App\Models\PostModel::class, 10)->create();
    }
}
