<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $this->call('ViewsSeeder');
        $this->command->info('views table seeded!');
        $this->call('RoleSeeder');
        $this->command->info('role table seeded!');
        $this->call('RoleViewSeeder');
        $this->command->info('role views table seeded!');
        $this->call('IdentificationTypeSeeder');
        $this->command->info('identification types table seeded!');
        $this->call('SecretariesSeeder');
        $this->command->info('secretaries table seeded!');
        $this->call('UsersSeeder');
        $this->command->info('users table seeded!');
        $this->call('GenderSeeder');
        $this->command->info('genders table seeded!');
        $this->call('SpecialConditionSeeder');
        $this->command->info('special conditions table seeded!');
        $this->call('EthnicGroupsSeeder');
        $this->command->info('ethnic groups table seeded!');
        $this->call('VisualSeeder');
        $this->command->info('visual impairments table seeded!');
        $this->call('MotorSeeder');
        $this->command->info('motor disabilities table seeded!');
        $this->call('HearingSeeder');
        $this->command->info('hearing impairments table seeded!');
        $this->call('AgeRangeSeeder');
        $this->command->info('age range table seeded!');
        $this->call('VictimTypesSeeder');
        $this->command->info('victim types table seeded!');
        $this->call('DepartmentsSeeder');
        $this->command->info('departments table seeded!');
        $this->call('ZoneSeeder');
        $this->command->info('zones table seeded!');
        $this->call('SisbenZonesSeeder');
        $this->command->info('sisben zones table seeded!');
        $this->call('AdminUnitTypeSeeder');
        $this->command->info('administrative unit types table seeded!');
        $this->call('AreaTypesSeeder');
        $this->command->info('area types table seeded!');
        $this->call('CounterSeeder');
        $this->command->info('counters table seeded!');
        $this->call('FilterSeeder');
        $this->command->info('filters table seeded!');
        $this->call('CounterFilterSeeder');
        $this->command->info('counter_filters table seeded!');
        $this->call('GenericFilterSeeder');
        $this->command->info('generic_filters table seeded!');
        
        if (app()->environment('local')) {
            $this->seedLocalEnvironment();
        }
    }

    public function seedLocalEnvironment() {
    }
}
