<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(VoyagerDatabaseSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ClientsTableSeeder::class);
        $this->call(CamerasTableSeeder::class);
        $this->call(ReasonsTableSeeder::class);
        $this->call(VisitorsTableSeeder::class);
        $this->call(ResponsiblesTableSeeder::class);
        $this->call(EntriesTableSeeder::class);
        
    }
}
