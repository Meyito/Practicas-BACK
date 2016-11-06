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
        $this->call('SecretariesSeeder');
        $this->command->info('secretaries table seeded!');
        $this->call('GenderSeeder');
        $this->command->info('genders table seeded!');

        if (app()->environment('local')) {
            $this->seedLocalEnvironment();
        }
    }

    public function seedLocalEnvironment() {
        $this->call('UsersSeeder');
        $this->command->info('users table seeded!');
    }
}
