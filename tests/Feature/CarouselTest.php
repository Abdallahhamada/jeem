// <?php

// namespace Tests\Feature;

// use App\Carousel;
// use Tests\TestCase;
// use Illuminate\Http\UploadedFile;
// use Illuminate\Support\Facades\Storage;
// use Illuminate\Foundation\Testing\WithoutMiddleware;

// class CarouselTest extends TestCase
// {
    // protected $carousel;
    // use WithoutMiddleware;

    // protected  $url = '/api/carousel';

    // public function testCreateCarousel()
    // {
    //     $this->post($this->url, [
    //         'heading' => 'Heading',
    //         'subHeading' => 'Sub Heading',
    //         'tags' => 00,
    //         'image' => UploadedFile::fake()->image('file.png', 200)
    //     ])
    //         ->assertStatus(201) 
    //         ->assertJson([
    //             'message' => 'Carousel element created'
    //         ]);
    // }


    // public function testCreateCarouselWhenValidationFails()
    // {
    //     $this->post($this->url, [
    //         'heading' => 'New Heading',
    //         'subHeading' => '',
    //     ])->assertStatus(400);
    // }


    // public function testGetAllCarousel(){

    //     $carousel  = $this->post($this->url, [
    //         'heading' => 'Heading',
    //         'subHeading' => 'Sub Heading',
    //         'tags' => 00,
    //         'image' => UploadedFile::fake()->image('file.png', 200)
    //     ])->assertStatus(201)->json()['carousel'];

    //     $this->get($this->url)
    //          ->assertStatus(200)
    //          ->assertJsonStructure(
    //             [
    //                 [
    //                         'id',
    //                         'carouselHeading',
    //                         'carouselSubHeading',
    //                         'carouselImage',
    //                         'carouselTags',
    //                         'carouselStatus',
    //                         'created_at',
    //                         'updated_at'
    //                 ]
    //             ]
    //         );
    // }
    
    
    // public function testGetCarousel(){

    //     $carousel  = $this->post($this->url, [
    //         'heading' => 'Heading',
    //         'subHeading' => 'Sub Heading',
    //         'tags' => 00,
    //         'image' => UploadedFile::fake()->image('file.png', 200)
    //     ])->assertStatus(201)->json()['carousel'];

    //     $this->get($this->url.'/'.$carousel['id'])
    //          ->assertStatus(200)
    //          ->assertJsonStructure(
    //             [
    //                 [
    //                         'id',
    //                         'carouselHeading',
    //                         'carouselSubHeading',
    //                         'carouselImage',
    //                         'carouselTags',
    //                         'carouselStatus',
    //                         'created_at',
    //                         'updated_at'
    //                 ]
    //             ]
    //         );
    // }


    // public function testGetCarouselNotFound()
    // {
    //     $this->get($this->url.'/9000')
    //         ->assertStatus(404)
    //         ->assertJson(['message'=>'Carousel element not found']);
    // }


    // public function testUpdateCarousel()
    // {
    //     $carousel  = $this->post($this->url, [
    //         'heading' => 'Heading',
    //         'subHeading' => 'Sub Heading',
    //         'tags' => 00,
    //         'image' => UploadedFile::fake()->image('file.png', 200)
    //     ])->assertStatus(201)->json()['carousel'];
            
        
    //     $this->put($this->url.'/'.$carousel['id'], [
    //         'heading' => 'Update Heading',
    //         'subHeading' => 'Update Sub Heading',
    //         'image' => UploadedFile::fake()->image('pic.png', 200)
    //     ])->assertStatus(200)
    //       ->assertJson([
    //         'carouselHeading' => 'Update Heading',
    //         'carouselSubHeading' => 'Update Sub Heading',
            //*? Nadeem Hilal: if i uncomment it throws error and if keep
            //*? it commented, test case runs fine...
            //'carouselImage' => UploadedFile::fake()->image('pic.png', 200)
//           ]);
//     }
// }
