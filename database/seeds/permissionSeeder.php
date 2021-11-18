<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class permissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        Role::create(['guard_name' => 'seller','name' => 'super-seller']);

        $data = [

            /// Products

            [
                'name' => 'all-products',
                'name_ar' => 'كل المنتجات',
                'guard_name' => 'subseller'
            ],

            [
                'name' => 'edit-product',
                'name_ar' => 'تعديل المنتج',
                'guard_name' => 'subseller'
            ],

            [
                'name' => 'create-product',
                'name_ar' => 'اضافة منتج',
                'guard_name' => 'subseller'
            ],

            [
                'name' => 'create-excel',
                'name_ar' => 'اضافة ملف',
                'guard_name' => 'subseller'
            ],

            [
                'name' => 'delete-product',
                'name_ar' => 'مسح منتج',
                'guard_name' => 'subseller'
            ],


            /// Tags

            [
                'name' => 'all-tags',
                'name_ar' => 'كل الموشرات',
                'guard_name' => 'subseller'
            ],

            [
                'name' => 'edit-tags',
                'name_ar' => 'تعديل موشر',
                'guard_name' => 'subseller'
            ],

            [
                'name' => 'create-tags',
                'name_ar' => 'اضافة موشر',
                'guard_name' => 'subseller'
            ],

            [
                'name' => 'delete-tags',
                'name_ar' => 'مسح موشر',
                'guard_name' => 'subseller'
            ],

            //// Meetings

            [
                'name' => 'all-meetings',
                'name_ar' => 'كل الاجتماعات',
                'guard_name' => 'subseller'
            ],

            [
                'name' => 'edit-meeting',
                'name_ar' => 'تعديل اجتماع',
                'guard_name' => 'subseller'
            ],

            [
                'name' => 'create-meeting',
                'name_ar' => 'اضافة اجتماع',
                'guard_name' => 'subseller'
            ],

            [
                'name' => 'show-meeting',
                'name_ar' => 'مشاهدة اجتماع',
                'guard_name' => 'subseller'
            ],

            [
                'name' => 'delete-meeting',
                'name_ar' => 'مسح اجتماع',
                'guard_name' => 'subseller'
            ],

            /// Carousel


            [
                'name' => 'all-carousels',
                'name_ar' => 'كل الدائري',
                'guard_name' => 'subseller'
            ],

            [
                'name' => 'edit-carousel',
                'name_ar' => 'تعديل دائري',
                'guard_name' => 'subseller'
            ],

            [
                'name' => 'create-carousel',
                'name_ar' => 'اضافة دائري',
                'guard_name' => 'subseller'
            ],

            [
                'name' => 'delete-carousel',
                'name_ar' => 'مسح دائري',
                'guard_name' => 'subseller'
            ],

            /// Post


            [
                'name' => 'all-posts',
                'name_ar' => 'كل البوستات',
                'guard_name' => 'subseller'
            ],

            [
                'name' => 'edit-post',
                'name_ar' => 'تعديل بوست',
                'guard_name' => 'subseller'
            ],

            [
                'name' => 'create-post',
                'name_ar' => 'اضافة بوست',
                'guard_name' => 'subseller'
            ],

            [
                'name' => 'delete-post',
                'name_ar' => 'مسح بوست',
                'guard_name' => 'subseller'
            ],

            /// Messages


            [
                'name' => 'all-messages',
                'name_ar' => 'كل الرسائل',
                'guard_name' => 'subseller'
            ],


            [
                'name' => 'create-message',
                'name_ar' => 'ارسال رسالة',
                'guard_name' => 'subseller'
            ],

            [
                'name' => 'show-message',
                'name_ar' => 'مشاهدة رسالة',
                'guard_name' => 'subseller'
            ],

            [
                'name' => 'delete-message',
                'name_ar' => 'مسح رسالة',
                'guard_name' => 'subseller'
            ],

            /// subsellers


            [
                'name' => 'all-subsellers',
                'name_ar' => 'كل المستخدمين',
                'guard_name' => 'subseller'
            ],

            [
                'name' => 'edit-subseller',
                'name_ar' => 'تعديل مستخدم',
                'guard_name' => 'subseller'
            ],

            [
                'name' => 'create-subseller',
                'name_ar' => 'اضافة مستخدم',
                'guard_name' => 'subseller'
            ],

            [
                'name' => 'delete-subseller',
                'name_ar' => 'مسح مستخدم',
                'guard_name' => 'subseller'
            ],

            /// orders

            [
                'name' => 'all-orders',
                'name_ar' => 'كل الطلبات',
                'guard_name' => 'subseller'
            ],

            [
                'name' => 'edit-order',
                'name_ar' => 'تعديل الطلب',
                'guard_name' => 'subseller'
            ],

            [
                'name' => 'delete-order',
                'name_ar' => 'مسح الطلب',
                'guard_name' => 'subseller'
            ],

            /// Negotiates

            [
                'name' => 'all-negotiates',
                'name_ar' => 'كل العروض',
                'guard_name' => 'subseller'
            ],

            [
                'name' => 'edit-negotiate',
                'name_ar' => 'تعديل سعر العرض',
                'guard_name' => 'subseller'
            ],

            [
                'name' => 'delete-negotiate',
                'name_ar' => 'مسح العرض',
                'guard_name' => 'subseller'
            ],

            /// Invoices

            [
                'name' => 'create-invoice',
                'name_ar' => 'انشاء فاتورة',
                'guard_name' => 'subseller'
            ],


            [
                'name' => 'edit-invoice',
                'name_ar' => 'تعديل فاتورة',
                'guard_name' => 'subseller'
            ],

            [
                'name' => 'delete-invoice',
                'name_ar' => 'مسح فاتورة',
                'guard_name' => 'subseller'
            ],

            //// Settings

            [
                'name' => 'change-password-seller',
                'name_ar' => 'تعديل كلمة السر',
                'guard_name' => 'subseller'
            ],
            //// profile
            [
                'name' => 'update-profile-seller',
                'name_ar' => 'تعديل الملف الشخصي',
                'guard_name' => 'subseller'
            ],
        ];

        foreach($data as $element){

            Permission::create($element);
        }
    }
}
