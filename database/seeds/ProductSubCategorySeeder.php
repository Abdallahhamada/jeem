<?php

use App\Models\Categories\ProductSubCategory;
use Illuminate\Database\Seeder;

class ProductSubCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = [
            /****مواد التنفيذ****/

            [
                'name_en' => 'Concrete',
                'name_ar' => 'خرسانة',
                'category_id' => 1,
                'category_sub_id' => 1,
                'image_name' => 'concrete.jpg',
                'image_path' => 'images/product_sub_category/concrete.jpg'
            ],


            [
                'name_en' => 'Blog',
                'name_ar' => 'بلوك',
                'category_id' => '1',
                'category_sub_id' => '1',
                'image_name' => 'brick1.jpg',
                'image_path' => 'images/product_sub_category/brick1.jpg'
            ],

            [
                'name_en' => 'iron',
                'name_ar' => 'حديد',
                'category_id' => '1',
                'category_sub_id' => '1',
                'image_name' => 'steel.jpg',
                'image_path' => 'images/product_sub_category/steel.jpg'
            ],

            [
                'name_en' => 'glass',
                'name_ar' => 'زجاج',
                'category_id' => '1',
                'category_sub_id' => '1',
                'image_name' => 'glass.jpg',
                'image_path' => 'images/product_sub_category/glass.jpg'
            ],

            [
                'name_en' => 'Plastic',
                'name_ar' => 'بلاستيك',
                'category_id' => '1',
                'category_sub_id' => '1',
                'image_name' => 'elevator.jpg',
                'image_path' => 'images/product_sub_category/elevator.jpg'
            ],

            [
                'name_en' => 'sand',
                'name_ar' => 'رمل',
                'category_id' => '1',
                'category_sub_id' => '1',
                'image_name' => 'sand.jpg',
                'image_path' => 'images/product_sub_category/sand.jpg'
            ],

            [
                'name_en' => 'Cement',
                'name_ar' => 'اسمنت',
                'category_id' => '1',
                'category_sub_id' => '1',
                'image_name' => 'cement.jpg',
                'image_path' => 'images/product_sub_category/cement.jpg'
            ],

            [
                'name_en' => 'Thermal insulation materials',
                'name_ar' => 'مواد العزل الحراري',
                'category_id' => '1',
                'category_sub_id' => '1',
                'image_name' => 'signupin.jpg',
                'image_path' => 'images/product_sub_category/signupin.jpg'
            ],

            //\\\\\\\\\\\\\\\\\\\\مواد البناء\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
            //\\\\\\\\\\\\\\\\\\\\ مواد التشطيب \\\\\\\\\\\\\\\\\\\\\\\\\\\

            [
                'name_en' => 'Paints',
                'name_ar' => 'دهانات',
                'category_id' => '1',
                'category_sub_id' => '2',
                'image_name' => 'paint.jpg',
                'image_path' => 'images/product_sub_category/paint.jpg'
            ],

            [
                'name_en' => 'Tiling',
                'name_ar' => 'التبليط',
                'category_id' => '1',
                'category_sub_id' => '2',
                'image_name' => 'bricksand.jpg',
                'image_path' => 'images/product_sub_category/bricksand.jpg'
            ],

            [
                'name_en' => 'Plumbing tools',
                'name_ar' => 'ادوات السباكة',
                'category_id' => '1',
                'category_sub_id' => '2',
                'image_name' => 'plumbing.jpg',
                'image_path' => 'images/product_sub_category/plumbing.jpg'
            ],
            [
                'name_en' => 'Electrical tools',
                'name_ar' => 'ادوات الكهرباء',
                'category_id' => '1',
                'category_sub_id' => '2',
                'image_name' => 'consulting.jpeg',
                'image_path' => 'images/product_sub_category/consulting.jpeg'
            ],

            [
                'name_en' => 'Doors',
                'name_ar' => 'الابواب',
                'category_id' => '1',
                'category_sub_id' => '2',
                'image_name' => 'doors.jpg',
                'image_path' => 'images/product_sub_category/doors.jpg'
            ],

            [
                'name_en' => 'Windows',
                'name_ar' => 'الشبابيك',
                'category_id' => '1',
                'category_sub_id' => '2',
                'image_name' => 'window.jpg',
                'image_path' => 'images/product_sub_category/window.jpg'
            ],

            [
                'name_en' => 'Lifts',
                'name_ar' => 'المصاعد',
                'category_id' => '1',
                'category_sub_id' => '2',
                'image_name' => 'elevator.jpg',
                'image_path' => 'images/product_sub_category/elevator.jpg'
            ],

            // //\\\\\\\\\\\\\\\\\\\\ المقاولين \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
            // //\\\\\\\\\\\\\\\\\\\\ مقاول تسليم مفتاح \\\\\\\\\\\\\\\\\\\\\\\\\\\\

            [
                'name_en' => 'Golden key',
                'name_ar' => 'مفتاح ذهبي',
                'category_id' => '2',
                'category_sub_id' => '3',
                'image_name' => 'bronzekey.jpg',
                'image_path' => 'images/product_sub_category/bronzekey.jpg'
            ],

            [
                'name_en' => 'Silver key',
                'name_ar' => 'مفتاح فضي',
                'category_id' => '2',
                'category_sub_id' => '3',
                'image_name' => 'silverkey.jpg',
                'image_path' => 'images/product_sub_category/silverkey.jpg'
            ],

            [
                'name_en' => 'Bronze key',
                'name_ar' => 'مفتاح برونزي',
                'category_id' => '2',
                'category_sub_id' => '3',
                'image_name' => 'lumpSumContracts.jpeg',
                'image_path' => 'images/product_sub_category/lumpSumContracts.jpeg'
            ],
            [
                'name_en' => 'Contractors',
                'name_ar' => 'المقاولين',
                'category_id' => '2',
                'category_sub_id' => '4',
                'image_name' => 'consultant.png',
                'image_path' => 'images/categories/consultant.png'
            ],
            [
                'name_en' => 'Engineering offices',
                'name_ar' => 'المكاتب الهندسية والإستشارية',
                'category_id' => '3',
                'category_sub_id' => '5',
                'image_name' => 'consultant.png',
                'image_path' => 'images/categories/contractors.png'
            ],
            [
                'name_en' => 'Engineering offices',
                'name_ar' => 'المكاتب الهندسية والإستشارية',
                'category_id' => '3',
                'category_sub_id' => '6',
                'image_name' => 'consultant.png',
                'image_path' => 'images/categories/contractors.png'
            ],
            [
                'name_en' => 'Engineering offices',
                'name_ar' => 'المكاتب الهندسية والإستشارية',
                'category_id' => '3',
                'category_sub_id' => '7',
                'image_name' => 'consultant.png',
                'image_path' => 'images/categories/contractors.png'
            ]
        ];

        foreach($data as $element){

            ProductSubCategory::create($element);
        }
    }
}
