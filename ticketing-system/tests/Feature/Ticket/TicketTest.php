<?php

namespace Tests\Feature\Ticket;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TicketTest extends TestCase
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
    public function setUp():void{
        parent::setUp();

        $this->user = User::factory()->create();
        Sanctum::actingAs($this->user);

    }

    // index
    public function test_only_support_can_get_all_ticket_list(){
        // seed classroom using relationship
        Ticket::factory(10)->for($this->user)->create();

        $this->getJson('api/ticket')->assertJson(
            ["data"=>
        [[
            "user_name"=>$this->user->name
        ]]])
        ->assertJsonCount(10,"data");
    }

    public function test_user_can_create_new_ticket(){
        $ticket=Ticket::factory()->make();
        // $data=Arr::except($class->toArray();

        $this->postJson('api/ticket', $ticket->toArray())
            ->assertJson([
                "data"=>[
                    "title"=>$ticket->title,
                    "user_name"=>$this->user->name
                ]
                ]);
    }

    public function test_user_can_update_existing_ticket(){

        $ticket =Ticket::factory()->for($this->user)->create([
            "title"=>"issue 1",
            "statuses_id"=> 1
        ]);

        $this->putJson('api/ticket/'.$ticket->id , ["statuses_id"=>3])
        ->assertJson([
            "data"=>[
            "status"=>"complete"]
        ]);

        $this->assertDatabaseHas(Ticket::class, [
            "user_id"=>$this->user->id,
            "title"=> "issue 1",
            "statuses_id"=>3
        ]);

    }

    public function test_user_can_view_existing_ticket(){
        $ticket =Ticket::factory()->for($this->user)->create();
    
            $this->getJson('api/ticket/'. $ticket->id)
            ->assertJson([
                "data"=>[
                "title"=>$ticket->title]
            ]);
    }

    public function test_user_can_delete_ticket(){
        $ticket =Ticket::factory()->for($this->user)->create();
    
            $this->deleteJson('api/ticket/'. $ticket->id)
            ->assertStatus(204);
    
            $this->assertDatabaseMissing(Ticket::class, [
                "user_id"=>$this->user->id,
                "title" => $ticket->title
            ]);
    }

    public function test_public_can_search_ticket_using_support_id(){
        // class belong to intended teacher we want to search
        $ticketA =Ticket::factory()->for($this->user)->create();
        $ticketB =Ticket::factory()->for($this->user)->create();
        // classroom belong to other teacher
        $ticketC =Ticket::factory()->for(User::factory()->create())->create();

        $this->postJson('api/ticket/search',[
            'user_id'=>$this->user->id
        ])
        ->assertJson([
            "data"=> [
                ["title"=>$ticketA->title],
                ["title"=>$ticketB->title]
            ]
        ])
        ->assertJsonCount(2,"data");


    }

    public function test_public_can_search_ticket_using_title_and_category(){
        $ticketA =Ticket::factory()->for($this->user)->create(["title"=>"problem A", 'categories_id'=>2]);
        $ticketB =Ticket::factory()->for($this->user)->create(["title"=>"masaalah B", 'categories_id'=>1]);
        $ticketC =Ticket::factory()->for($this->user)->create(["title"=>"masaalah C", 'categories_id'=>3]);

        $this->postJson('api/ticket/search',[
            'category_name'=>'Meniaga',
            'search_title'=>'masa'
        ])
        ->assertJson([
            "data"=> [
                ["title"=>$ticketB->title]
            ]
        ])
        ->assertJsonCount(1,"data");

    }

    public function test_public_can_search_title_using_title_and_support_name(){

        $user =User::factory()->create(["name"=>"Bakar Abu"]);
        $ticketA =Ticket::factory()->for($user)->create(["title"=>"This Problem Ticket"]);
        $ticketB =Ticket::factory()->for($user)->create(["title"=>"Masaalah"]);
        $ticketC =Ticket::factory()->for($user)->create(["title"=>"Masaalah 4"]);

        $this->postJson('api/ticket/search',[
            'search_user_name'=>'Abu',
            'search_title'=>'masaalah'
        ])
        ->assertJson([
            "data"=> [
                ["title"=>$ticketB->title],
                ["title"=>$ticketC->title]
            ]
        ])
        ->assertJsonCount(2,"data");
    }

}