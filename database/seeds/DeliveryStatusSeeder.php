<?php

use Illuminate\Database\Seeder;
use App\Models\DeliveryStatus\DeliveryStatus;

class DeliveryStatusSeeder extends Seeder
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
                'name_ar' => 'تم الطلب بإنتظار التأكيد ',
                'name_en' => 'order placed waiting for conformation'
            ],

            [
                'name_ar' => 'تم إرسال الفاتورة الى بريدكم الالكتروني ومتوفرة في صفحتكم',
                'name_en' => 'bill is sent to your account please pay '
            ],
            [
                'name_ar' => 'الرجاء الدفع تجنباً لالغاء الطلب',
                'name_en' => 'to avoid order cancletion please pay'
            ],
            [
                'name_ar' => 'طلب ملغي لم يتم الدفع',
                'name_en' => 'order cancled due no payment '
            ],
            [
                'name_ar' => ' طلب ملغي من المشتري ',
                'name_en' => 'order cancelled from the buyer'
            ], [
                'name_ar' => ' طلب ملغي من البائع ',
                'name_en' => 'order cancelled from the seller'
            ],

            [
                'name_ar' => 'طلب مؤكد بإنتظار الشحن',
                'name_en' => 'confrmied order waiting for the shipping'
            ],
            [
                'name_ar' => 'طلب مغلف \جاهز للشحن  ',
                'name_en' => ' order packed \Ready for shipping '
            ],
            [
                'name_ar' => 'تم الشحن المندوب سيقوم بالتواصل ',
                'name_en' => 'shipped agent will be contacting you'
            ],
            [
                'name_ar' => 'الشحنة مع المندوب ',
                'name_en' => 'shippement is with agent '
            ],
            [
                'name_ar' => ' تم التوصيل  ',
                'name_en' => 'order deliverd '
            ], [
                'name_ar' => '  لم يتم التوصيل ',
                'name_en' => 'order is not deliverd '
            ],

        ];

        foreach($data as $element) {
            DeliveryStatus::create($element);
        }
    }
}
