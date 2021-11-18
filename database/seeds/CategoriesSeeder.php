<?php

use App\Models\Categories\Categories;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name_en' => 'Building materials',
                'name_ar' => 'مواد البناء',
                'image_name' => 'architecture.png',
                'image_path' => 'images/categories/architecture.png'
            ],

            [
                'name_en' => 'Contractors',
                'name_ar' => 'المقاولين',
                'image_name' => 'consultant.png',
                'image_path' => 'images/categories/consultant.png'
            ],

            [
                'name_en' => 'Engineering offices',
                'name_ar' => 'المكاتب الهندسية والإستشارية',
                'image_name' => 'contractors.png',
                'image_path' => 'images/categories/contractors.png'
            ]
        ];

        foreach ($data as $element) {
            Categories::create(
                $element
            );
        }
    }
}
