<?php

namespace Tests\Feature;

use App\User;
use App\Address;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class CompanyTest extends TestCase
{
    protected $company;
    protected $address;
    use WithoutMiddleware;
    protected $url = '/api/company';

    public function setUp():void
    {
        parent::setUp();

        $this->company = new User;
        $this->company->name = 'Test';
        $this->company->role_id = 3;
        $this->company->email= 'geekz_den@gmail.com';
        $this->company->verified= 1;
        $this->company->password= "letusc123";
        $this->company->accountstatus= "active";
        $this->company->save();

        $this->address = new Address;
        $this->address->userId = $this->company->id;
        $this->address->name = $this->company->id;
        $this->address->address = 'address';
        $this->address->address1 = 'address01';
        $this->address->city = 'Srinagar';
        $this->address->state= 'Kashmir';
        $this->address->country= 'IOK';
        $this->address->pincode= 123123;
        $this->address->isActive= 1;
        $this->address->save();
        // $headers = ['Authorization' => 'Bearer '.\JWTAuth::fromUser($this->user)];
        // dd($headers['Authorization']);
    }


    /** @test */
    public function test_check_company_is_found()
    {
        $this->get($this->url.'/'.$this->company->id)
        ->assertStatus(200)->assertJson([
            [
                'name' => $this->company->name,
                'email' => $this->company->email,
                'address' => $this->address->address
        ]]);
    }

    /** @test */
    public function test_check_company_not_found()
    {
        $this->get($this->url.'/1000')
        ->assertStatus(404)->assertJson([
                'message' => 'Seller not found'
        ]);
    }

    /** @test */
    public function test_check_company_image_name_is_updated()
    {

        $this->put($this->url.'/'.$this->company->id, [
            'image' => UploadedFile::fake()->image('file.png', 200),
            'name'=>'GEEKZ DEN'

        ])->assertStatus(200);

        $company = User::where('email', '=', $this->company->email)->first();
        assert(
            $company->name === 'GEEKZ DEN' && $company->logo != $this->company->logo,
            'Name image not updated'
        );
    }


    //----------------------------------------------------------------------------
    //*!@"Nadeem Hilal":- I got stuck while writing this test case 
    //----------------------------------------------------------------------------
    // public function check_company_image_upload_fails_due_to_wrong_format()
    // {
    //     $response = $this->put('/api/company/'.$this->company->id, [
    //         'image' => 'name',
    //     ]);

    //     # Todo: Sajid, it must throw status code 400 and some proper error message related to image format
    //     // $response->assertStatus(302);
    //     $response->assertStatus(400)->assertJson([
    //         'message' => 'Wrong format is used for uploading image'
    // ]);
    // }
}
