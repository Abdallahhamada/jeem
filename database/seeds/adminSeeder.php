<?php

use App\Models\Admin\Admin;
use Illuminate\Database\Seeder;

class adminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            "name" => 'Mahmoud Abd Alziem',
            "email" => 'admin@gmail.com',
            "password" => bcrypt(12345678),
            "reminder" => 9781,
            "count" => 9781
        ]);
    }
}
