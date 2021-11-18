<?php

namespace Tests\Feature;

use App\SellerCategory;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class SellerCategoryTest extends TestCase
{
    protected $seller_category;
    use WithoutMiddleware;

    protected $url = '/api/sellercategory';

    public function testCreateSellerCategory()
    {
        $this->post($this->url, [
            'name' => 'Sally',
            'category_status' => 'active',
            'image' => UploadedFile::fake()->image('file.png', 200)
        ])
            ->assertStatus(201)
            ->assertJson([
                'message' => 'Seller category created'
            ]);
    }


    public function testCreateSellerCategoryThrowErrorWhenValidationFails()
    {
        $this->post($this->url, [
            'name' => '',
            'category_status' => 'active'
        ])->assertStatus(400);
    }


    public function testGetAllSellerCategory()
    {
        
        $seller_category  = $this->post($this->url, [
            'name' => 'Tony Montana',
            'image' => UploadedFile::fake()->image('file.png', 200)
        ])->assertStatus(201)->json()['seller_category'];

        $this->get($this->url)
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    [
                            'id',
                            'categoryName',
                            'categoryStatus',
                            'categoryImage',
                            'created_at',
                            'updated_at'
                    ]
                ]
            );
    }


    public function testGetSellerCategory(){

        $seller_category  = $this->post($this->url, [
            'name' => 'Tony Montana',
            'image' => UploadedFile::fake()->image('file.png', 200)
        ])->assertStatus(201)->json()['seller_category'];

        $this->get($this->url.'/'.$seller_category['id'])
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    [
                            'id',
                            'categoryName',
                            'categoryStatus',
                            'categoryImage',
                            'created_at',
                            'updated_at'
                    ]
                ]
            );
    }


    public function testGetSellerCategoryNotFound()
    {
        $this->get($this->url.'/9000')
            ->assertStatus(404)
            ->assertJson(['message'=>'Seller Category not found']);
    }


    public function testUpdateSellerCategory()
    {
        $seller_category  = $this->post($this->url, [
            'name' => 'Joker',
            'category_status' => 'active',
            'image' => UploadedFile::fake()->image('file.png', 200)
        ])->assertStatus(201)->json()['seller_category'];

        
        $this->put($this->url.'/'.$seller_category['id'], [
            'name'=>'Joaquin',
            'image' => UploadedFile::fake()->image('pic.png', 200)
        ])->assertStatus(200)
          ->assertJson([
            'categoryName'=> 'Joaquin',
          ]);
    }
}
