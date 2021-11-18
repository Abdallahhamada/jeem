<?php

namespace Tests\Feature;

use App\ProductCategory;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ProductCategoryTest extends TestCase
{
    protected $product_category;
    use WithoutMiddleware;

    protected  $url = '/api/productcategory';

    public function testCreateProductCategory()
    {
        $this->post($this->url, [
            'sellerCategory' => 'Building',
            'productCategory' => 'Construction',
            'image' => UploadedFile::fake()->image('file.png', 200)
        ])
            ->assertStatus(201) 
            ->assertJson([
                'message' => 'Product Category created'
            ]);
    }


    public function testCreateProductCategoryWhenValidationFails()
    {
        $this->post($this->url, [
            'sellerCategory' => 'Architecture Firms',
            'productCategory' => '',
        ])->assertStatus(400);
    }


    public function testGetAllProductCategory()
    {
        
        $product_category  = $this->post($this->url, [
            'sellerCategory' => 'Building',
            'productCategory' => 'Construction',
            'image' => UploadedFile::fake()->image('file.png', 200)
        ])->assertStatus(201)->json()['Product category'];

        $this->get($this->url)
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    [
                            'id',
                            'productCategoryName',
                            'productCategoryImage',
                            'sellerCategoryName',
                            'productCategoryStatus',
                            'created_at',
                            'updated_at'
                    ]
                ]
            );
    }


    public function testGetProductCategory(){

        $product_category  = $this->post($this->url, [
            'sellerCategory' => 'Building',
            'productCategory' => 'Construction',
            'image' => UploadedFile::fake()->image('file.png', 200)
        ])->assertStatus(201)->json()['Product category'];

        $this->get($this->url.'/'.$product_category['id'])
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    [
                            'id',
                            'productCategoryName',
                            'sellerCategoryName',
                            'productCategoryImage',
                            'productCategoryStatus',
                            'created_at',
                            'updated_at'
                    ]
                ]
            );
    }


    public function testGetProductCategoryNotFound()
    {
        $this->get($this->url.'/9000')
            ->assertStatus(404)
            ->assertJson(['message'=>'Product Category not found']);
    }


    public function testUpdateProductCategory()
    {
        $product_category  = $this->post($this->url, [
            'sellerCategory' => 'Building',
            'productCategory' => 'Construction',
            'image' => UploadedFile::fake()->image('file.png', 200)
        ])->assertStatus(201)->json()['Product category'];
            
        
        $this->put($this->url.'/'.$product_category['id'], [
            'sellerCategory' => 'Architecture',
            'productCategory' => 'Engineering',
            'image' => UploadedFile::fake()->image('pic.png', 200)
        ])->assertStatus(200)
          ->assertJson([
            'sellerCategoryName'=> 'Architecture',
            'productCategoryName' => 'Engineering',
          ]);
    }
}


