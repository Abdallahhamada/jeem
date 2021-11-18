<?php

use App\Models\Seller\Seller;
use Illuminate\Database\Seeder;

class sellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user =Seller::create([
            "name" => "Mahmoud Abd alziem",
            "email" => 'seller@gmail.com',
            "password" => bcrypt(12345678),
            "phone" => '010074492985',
            "city" => "madina",
            "category_id" => 1,
            'active' => 1,
            'verified' => 1,
            "unique_id" => rand(5643546456547, 967484565464562)
        ]);

        $user->assignRole('super-seller');
    }
}
