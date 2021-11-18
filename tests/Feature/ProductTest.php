<?php

namespace Tests\Feature;

use App\Product;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ProductTest extends TestCase
{
    protected $product;
    use WithoutMiddleware;

    protected  $url = '/api/product';
    protected  $url2 = '/api/products';

    // public function testCreateProduct()
    // {
    //     $this->post($this->url, [
    //         'name' => 'New Product',
    //         'productSubCategoryId' => 6,
    //         'productSellerId' => 3,
    //         'arrayimages' => [
    //                             UploadedFile::fake()->image('file.png', 200),
    //                             UploadedFile::fake()->image('file.png', 200)
    //         ],
    //         'price' => 44.99,
    //         'discountPrice' => 22,
    //         'cartDesc' => 'New Cart Description',
    //         'addInfo' => 'New Add Info',
    //         'techSpecs' => 'New Tech Features',
    //         'stock' => 76,
    //         'tags' => 88
    //     ])
    //         ->assertStatus(201) 
    //         ->assertJson([
    //             'message' => 'Product added'
    //         ]);
    // }


    public function testCreateProductWhenValidationFails()
    {
        $this->post($this->url, [
            'name' => 'New Product',
            'productSubCategoryId' => 6,
            'arrayimages.*' =>  '',
        ])->assertStatus(400);
    }


    // public function testGetProduct()
    // {
    //     $product  = $this->post($this->url, [
    //         'name' => 'New Product',
    //         'productSubCategoryId' => 6,
    //         'arrayimages' => [
    //                             UploadedFile::fake()->image('file.png', 200),
    //                             UploadedFile::fake()->image('file.png', 200)
    //         ],
    //         'price' => 44.99,
    //         'discountPrice' => 22,
    //         'cartDesc' => 'New Cart Description',
    //         'addInfo' => 'New Add Info',
    //         'techSpecs' => 'New Tech Features',
    //         'stock' => 76,
    //         'tags' => 88
    //     ])->assertStatus(201)->json()['Product'];

    //     $this->get($this->url.'/'.$product['id'])
    //         ->assertStatus(200)
    //         ->assertJsonStructure(
    //             [
    //                 [
    //                         'id',
    //                         'productSubCategoryId',
    //                         'productSku',
    //                         'productName',
    //                         'productPrice',
    //                         'productDiscountedPrice',
    //                         'productDiscount',
    //                         'productImages',
    //                         'productStatus',
    //                         'productCartDesc',
    //                         'productAddInfo',
    //                         'productTechSpecs',
    //                         'productThumb',
    //                         'productUpdateDate',
    //                         'productStock',
    //                         'productTags',
    //                         'created_at',
    //                         'updated_at'
    //                 ]
    //             ]
    //         );
    // }


    public function testGetProductNotFound()
    {
        $this->get($this->url.'/9000')
            ->assertStatus(404)
            ->assertJson(['message'=>'Product not found']);
    }


    // public function testUpdateProduct()
    // {
    //     $product  = $this->post($this->url, [
    //         'name' => 'New Product',
    //         'productSubCategoryId' => 6,
    //         'arrayimages' => [
    //                             UploadedFile::fake()->image('file.png', 200),
    //                             UploadedFile::fake()->image('file.png', 200)
    //         ],
    //         'price' => 44.99,
    //         'cartDesc' => 'New Cart Description',
    //         'addInfo' => 'New Add Info',
    //         'techSpecs' => 'New Tech Features',
    //         'stock' => 76,
    //         'tags' => 88
    //     ])->assertStatus(201)->json()['Product'];
            
        
    //     $this->put($this->url.'/'.$product['id'], [
    //         'name' => 'Update Product',
    //         'arrayimages' => [
    //                             UploadedFile::fake()->image('pic1.png', 200),
    //                             UploadedFile::fake()->image('pic2.png', 200)
    //         ],
    //         'price' => 33.88,
    //         'cartDesc' => 'Update Cart Description',
    //         'addInfo' => 'Update Add Info',
    //         'techSpecs' => 'Update Tech Features',
    //         'stock' => 70,
    //         'tags' => 88
    //     ])->assertStatus(200)
    //       ->assertJson([
    //         'productName' => 'Update Product',
    //         'productPrice' => 33.88,
    //         'productCartDesc' => 'Update Cart Description',
    //         'productAddInfo' => 'Update Add Info',
    //         'productTechSpecs' => 'Update Tech Features',
    //         'productStock' => 70,
    //         'productTags' => 88,
    //       ]);
    // }
}
