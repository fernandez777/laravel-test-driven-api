<?php

namespace Tests\Feature;

use App\Models\TodoList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodoListTest extends TestCase
{

    use RefreshDatabase;

    protected $list;

    public function setup(): void
    {
        parent::setup();
        $this->list =  TodoList::factory()->create();
    }

    public function test_fetch_all_todo_lists_example()
    {
        $response = $this->getJson(route('todo-list.index'));

        $this->assertEquals(1, count($response->json()));        
    }

    public function test_fetch_single_todo_list()
    {

        $response = $this->getJson(route('todo-list.show', $this->list->id))
                        ->assertok()
                        ->json();

        $this->assertEquals($response['name'], $this->list->name);
    }

    public function test_store_new_todo_list()
    {
        $this->postJson(route('todo-list.store', ['name'=>'my list']))
            ->assertCreated();
        $this->assertdatabaseHas('todo_lists', ['name'=>'my list']);
    }

}
