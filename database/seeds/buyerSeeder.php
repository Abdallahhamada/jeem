<?php

use App\Models\Buyer\Buyer;
use Illuminate\Database\Seeder;

class buyerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Buyer::create([
            "name" => "Mohamed Reda Hamza",
            "email" => 'buyer@gmail.com',
            "password" => bcrypt(12345678),
            "verified" => 1,
            "phone" => '010074492982',
            "unique_id" => rand(5643546456547, 967484565464562)
        ]);
    }
}
