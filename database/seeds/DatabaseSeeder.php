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
        $this->call('IdentificationTypeSeeder');
        $this->command->info('identification types table seeded!');

        if (app()->environment('local')) {
            $this->seedLocalEnvironment();
        }
    }

    public function seedLocalEnvironment() {
        
    }
}
