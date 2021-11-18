<?php

namespace Tests\Feature;

use App\ProductSubCategory;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ProductSubCategoryTest extends TestCase
{
    protected $product_sub_category;
    use WithoutMiddleware;

    protected  $url = '/api/productsubcategory';
    protected  $url2 = '/api/productsubcategories';

    public function testCreateProductSubCategory()
    {
        $this->post($this->url, [
            'sellerCategory' => 'Building',
            'productCategory' => 'Construction',
            'productSubCategory' => 'خرسانة',
            'image' => UploadedFile::fake()->image('file.png', 200)
        ])
            ->assertStatus(201) 
            ->assertJson([
                'message' => 'Product Sub Category created'
            ]);
    }


    public function testCreateProductSubCategoryWhenValidationFails()
    {
        $this->post($this->url, [
            'sellerCategory' => 'Architecture Firms',
            'productCategory' => '',
            'productSubCategory' => 'خرسانة',
        ])->assertStatus(400);
    }
    //----------------------------------------------------------------------------
    //*?@"Nadeem Hilal":- Please check this out and tell me where i am doing wrong
    //----------------------------------------------------------------------------
    
    // public function testGetAllProductSubCategory()
    // {
        
    //     $product_sub_category  = $this->post($this->url, [
    //         'sellerCategory' => 'Building',
    //         'productCategory' => 'Construction',
    //         'productSubCategory' => 'خرسانة',
    //         'image' => UploadedFile::fake()->image('file.png', 200)
    //     ])->assertStatus(201)->json()['Product Sub Category'];

    //     $this->post($this->url2,[
    //         'page' => 0,
    //         'limit' => 10
    //     ])->assertStatus(200)
    //       // ->assertStatus(201)
    //         ->assertJsonStructure(
    //             [
    //                 [
    //                         'id',
    //                         'productCategoryName',
    //                         'sellerCategoryName',
    //                         'productCategoryStatus',
    //                         'created_at',
    //                         'updated_at'
    //                 ]
    //             ]
    //         );
    // }


    public function testGetProductSubCategory(){

        $product_sub_category  = $this->post($this->url, [
            'sellerCategory' => 'Building',
            'productCategory' => 'Construction',
            'productSubCategory' => 'خرسانة',
            'image' => UploadedFile::fake()->image('file.png', 200)
        ])->assertStatus(201)->json()['Product Sub Category'];

        $this->get($this->url.'/'.$product_sub_category['id'])
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    [
                            'id',
                            'sellerCategoryName',
                            'productCategoryName',
                            'productSubCategoryName',
                            'productSubCategoryImage',
                            'productSubCategoryStatus',
                            'created_at',
                            'updated_at'
                    ]
                ]
            );
    }


    public function testGetProductSubCategoryNotFound()
    {
        $this->get($this->url.'/9000')
            ->assertStatus(404)
            ->assertJson(['message'=>'Product Sub Category not found']);
    }


    public function testUpdateProductCategory()
    {
        $product_sub_category  = $this->post($this->url, [
            'sellerCategory' => 'Building',
            'productCategory' => 'Construction',
            'productSubCategory' => 'خرسانة',
            'image' => UploadedFile::fake()->image('file.png', 200)
        ])->assertStatus(201)->json()['Product Sub Category'];
            
        
        $this->put($this->url.'/'.$product_sub_category['id'], [
            'sellerCategory' => 'Building',
            'productCategory' => 'Finishing',
            'productSubCategory' => 'حديد',
            'image' => UploadedFile::fake()->image('pic.png', 200)
        ])->assertStatus(200)
          ->assertJson([
            'sellerCategoryName' => 'Building',
            'productCategoryName' => 'Finishing',
            'productSubCategoryName' => 'حديد',
          ]);
    }
}