<?php

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
        $this->call(DeliveryStatusSeeder::class);
        $this->call(permissionSeeder::class);
        $this->call(adminSeeder::class);
        $this->call(CategoriesSeeder::class);
        $this->call(SubcategorySeeder::class);
        $this->call(ProductSubCategorySeeder::class);
        $this->call(buyerSeeder::class);
        $this->call(sellerSeeder::class);
    }
}
