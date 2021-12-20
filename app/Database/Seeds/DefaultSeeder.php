<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DefaultSeeder extends Seeder
{
    public function run()
    {
        $this->call('UserSeeder');
        $this->call('GroupSeeder');
        $this->call('ModulSeeder');
        $this->call('MenuSeeder');
        $this->call('GroupUserSeeder');
        $this->call('GroupMenuSeeder');
        $this->call('SettingSeeder');
        $this->call('DeviceSeeder');
        $this->call('DataMesinSeeder');
    }
}
