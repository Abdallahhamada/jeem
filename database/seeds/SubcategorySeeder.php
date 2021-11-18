<?php

use App\Models\Categories\Subcategory;
use Illuminate\Database\Seeder;

class SubcategorySeeder extends Seeder
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
                'name_en' => 'Execution materials',
                'name_ar' => 'مواد التنفيذ',
                'category_id' => 1,
                'image_name' => 'skeletonContracts.jpg',
                'image_path' => 'images/sub_category/skeletonContracts.jpg'
            ],

            [
                'name_en' => 'Finishing materials',
                'name_ar' => 'مواد التشطيب',
                'category_id' => 1,
                'image_name' => 'paint.jpg',
                'image_path' => 'images/sub_category/paint.jpg'
            ],

            [
                'name_en' => 'Turnkey contractor',
                'name_ar' => 'مقاول تسليم مفتاح',
                'category_id' => 2,
                'image_name' => 'bronzekey.jpg',
                'image_path' => 'images/sub_category/bronzekey.jpg'
            ],

            [
                'name_en' => 'Bone contractor',
                'name_ar' => 'مقاول عظم',
                'category_id' => 2,
                'image_name' => 'contractors.jpeg',
                'image_path' => 'images/sub_category/contractors.jpeg'
            ],
            [
                'name_en' => 'Decision wins',
                'name_ar' => 'تصميم وتنفيذ',
                'category_id' => 3,
                'image_name' => 'survey.jpeg',
                'image_path' => 'images/sub_category/survey.jpeg'
            ],

            [
                'name_en' => 'Architectural design',
                'name_ar' => 'تصميم معماري',
                'category_id' => 3,
                'image_name' => 'lighting.jpg',
                'image_path' => 'images/sub_category/lighting.jpg'
            ],

            [
                'name_en' => 'interior design',
                'name_ar' => 'تصميم داخلي',
                'category_id' => 3,
                'image_name' => 'officedesign.png',
                'image_path' => 'images/sub_category/officedesign.png'
            ]
        ];

        foreach($data as $element){
            Subcategory::create($element);
        }
    }
}
