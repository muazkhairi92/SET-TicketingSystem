<?php

namespace Tests\Feature\User;

use App\Http\Requests\AddUserRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // public function test_example()
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }


    public function setUp():void
    {
       parent::setUp();

       $user = User::factory()->create([
           'name'=>'helllo',
           'password'=>'password123',
           'roles' => 'admin'       
        ]);

       Sanctum::actingAs($user);
    //    Sanctum::actingAs($userB);
        // $user->assignRole($user['roles']);
    }

    public function checkInput($payLoad){
        return Validator::make(
            // payload
            $payLoad,
            // extract rules from class
            // app()->call([AddTeacherRequest::class,'rules']),
            (new AddUserRequest())->rules()// stop onfirst fail
           ) ->stopOnFirstFailure()
            // true if validation pass
            ->fails();
    }

    public function test_all_validation(){
        $this->assertEquals($this->checkInput([
            [
                'name'=>'sapaaa',
                'password' => 'aea1a123',
            ]
            ]),true);

            $this->assertEquals($this->checkInput([
                [
                    'name'=>'sapaaa',
                    'password' => 'as2',
                ]
                ]),true);
    }

                // to test to get teacher list
    public function test_only_admin_can_get_user_list()
    {        
        $response = $this->getJson('api/user');
        // to check response
        $response->assertStatus(200);

        // check "suppport" permission on all users
        $userB = User::factory()->create([
            'roles' => 'support'       
         ]);
        Sanctum::actingAs($userB);
        $response = $this->getJson('api/user');
        // to check response
        $response->assertStatus(403);

        //  check "developer" permission on all user
        $userC = User::factory()->create([
            'roles' => 'developer'       
         ]);
        Sanctum::actingAs($userC);
        $response = $this->getJson('api/user');
        // to check response
        $response->assertStatus(403);
    
    }
            
    public function test_can_register_user()
    {
        $user= $this->getUser();
        $response = $this->postJson('api/register', [
                        'name' => $user['name'],
                        'password' => 'hhi24',
                        'email' => $user['email'],
                        'roles' => 'admin',
                    ]);
            
        $response->assertOk();
            
        $this->assertDatabaseHas(User::class,[
                        'name'=> $user['name']
                    ]);
    }

    public function test_can_login_user(){

        $response = $this->postJson('api/login', [
            'name' => 'helllo',
            'password' => 'password123',
        ]);

        $response->assertOk();

        $this->assertDatabaseHas(User::class,[
            'name'=> 'helllo'
        ]);
    }


}
