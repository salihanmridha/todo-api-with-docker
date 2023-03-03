<?php

namespace Tests\Feature;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class TodoTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Unauthenticated user cant access all todos and redirect to login get route
     */
    public function test_unauthenticated_user_cant_get_all_todos(): void
    {
        $response = $this->get('api/todos');

        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect("api/login");
    }

    /**
     * Unauthenticated user cant create todos and redirect to login get route
     */
    public function test_unauthenticated_user_cant_create_todo(): void
    {
        $attr = [
            "name" => "todo name",
            "description" => "todo desc",
        ];
        $response = $this->post('api/todos', $attr);

        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect("api/login");

    }

    /**
     * Unauthenticated user cant access single todos and redirect to login get route
     */
    public function test_unauthenticated_user_cant_get_single_todo(): void
    {
        $response = $this->get('api/todos/1');

        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect("api/login");
    }

    /**
     * Unauthenticated user cant update todos and redirect to login get route
     */
    public function test_unauthenticated_user_cant_update_todo(): void
    {
        $attr = [
            "name" => "todo name",
            "description" => "todo desc",
        ];
        $response = $this->put('api/todos/1', $attr);

        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect("api/login");
    }

    /**
     * Unauthenticated user cant delete todos and redirect to login get route
     */
    public function test_unauthenticated_user_cant_delete_todo(): void
    {
        $response = $this->delete('api/todos/1');

        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect("api/login");
    }

    //authenticate user test cases start here

    /**
     * authenticated user can create todo
     */
    public function test_authenticated_user_can_create_todo(): void
    {
        $user = User::factory()->create();

        $attr = [
            "name" => "todo name",
            "description" => "todo desc",
        ];
        $response = $this->actingAs($user, 'sanctum')->post('api/todos', $attr);
        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson([
            "status" => Response::HTTP_CREATED,
            "success" => true,
            "message" => "TODO created successfully",
            "data" => [
                "name" => $attr["name"],
                "description" => $attr["description"],
            ],
        ]);

        $this->assertDatabaseHas('todos', [
            "name" => $attr["name"],
            "description" => $attr["description"],
            "user_id" => $user->id,
        ]);
    }

    /**
     * authenticated user can not create todo without fill required filled name
     */
    public function test_authenticated_user_cannot_create_todo_without_fill_name(): void
    {
        $user = User::factory()->create();

        $attr = [
            "description" => "todo desc",
        ];
        $response = $this->actingAs($user, 'sanctum')->post('api/todos', $attr);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
//        dd($response->getContent());
        $response->assertJson([
            "status" => Response::HTTP_UNPROCESSABLE_ENTITY,
            "success" => false,
            "message" => "The name field is required.",
            "errors" => [],
        ]);

        $this->assertDatabaseMissing('todos', [
            "description" => $attr["description"],
            "user_id" => $user->id,
        ]);
    }

    /**
     * authenticated user can get todo list
     */
    public function test_authenticated_user_can_get_todo_list(): void
    {
        $user = User::factory()->create();

        Todo::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->get('api/todos');
        $response->assertStatus(Response::HTTP_OK);
        //dd($response->getContent());
        $response->assertJson([
            "status" => Response::HTTP_OK,
            "success" => true,
            "data" => [],
        ]);
    }

    /**
     * authenticated user can view todo with tasks
     */
    public function test_authenticated_user_can_view_todo_with_tasks(): void
    {
        $user = User::factory()->create();

        Todo::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->get('api/todos/1');
        $response->assertStatus(Response::HTTP_OK);
//        dd($response->getContent());
        $response->assertJson([
            "status" => Response::HTTP_OK,
            "success" => true,
            "data" => [
                "tasks" => []
            ],
        ]);
    }

    /**
     * authenticated user can not view other user todo
     */
    public function test_authenticated_user_can_not_view_other_user_todo(): void
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create([
            "name" => "Tonmoy",
            "email" => "tonmoy@email.com",
        ]);

        Todo::factory()->create();
        $user2Todo = Todo::factory()->create([
            "name" => "user 2 todo",
            "user_id" => $user2->id,
        ]);

        $response = $this->actingAs($user, 'sanctum')->get('api/todos/' . $user2Todo->id);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
//        dd($response->getContent());
        $response->assertJson([
            "status" => Response::HTTP_NOT_FOUND,
            "success" => false,
            "error" => "Todo not found",
        ]);
    }

    /**
     * authenticated user can update todo
     */
    public function test_authenticated_user_can_update_todo(): void
    {
        $user = User::factory()->create();

        Todo::factory()->create();

        $attr = [
            "name" => "updated todo name",
        ];
        $response = $this->actingAs($user, 'sanctum')->put('api/todos/1', $attr);
        $response->assertStatus(Response::HTTP_ACCEPTED);
//        dd($response->getContent());

        $response->assertJson([
            "status" => Response::HTTP_ACCEPTED,
            "success" => true,
            "message" => "Todo updated successfully",
            "data" => [
                "name" => $attr["name"],
            ],
        ]);

        $this->assertDatabaseHas('todos', [
            "name" => $attr["name"],
            "user_id" => $user->id,
        ]);
    }

    /**
     * authenticated user can not update other user todo
     */
    public function test_authenticated_user_can_not_update_other_user_todo(): void
    {
        $user = User::factory()->create();

        $user2 = User::factory()->create([
            "name" => "Tonmoy",
            "email" => "tonmoy@email.com",
        ]);

        Todo::factory()->create();
        $user2Todo = Todo::factory()->create([
            "name" => "user 2 todo",
            "user_id" => $user2->id,
        ]);

        $attr = [
            "name" => "updated todo name",
        ];
        $response = $this->actingAs($user, 'sanctum')->put('api/todos/' . $user2Todo->id, $attr);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
//        dd($response->getContent());

        $response->assertJson([
            "status" => Response::HTTP_NOT_FOUND,
            "success" => false,
            "error" => "Todo not found",
        ]);

        $this->assertDatabaseMissing('todos', [
            "name" => $attr["name"],
        ]);
    }


    /**
     * authenticated user can delete todo
     */
    public function test_authenticated_user_can_delete_todo(): void
    {
        $user = User::factory()->create();

        $todo = Todo::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->delete('api/todos/' . $todo->id);
        $response->assertStatus(Response::HTTP_ACCEPTED);
//        dd($response->getContent());

        $response->assertJson([
            "status" => Response::HTTP_ACCEPTED,
            "success" => true,
            "message" => $todo->name . " todo deleted successfully",
        ]);

        $this->assertDatabaseMissing('todos', [
            "name" => $todo->name,
        ]);
    }

    /**
     * authenticated user can not delete other user todo
     */
    public function test_authenticated_user_cant_delete_other_user_todo(): void
    {
        $user = User::factory()->create();

        $user2 = User::factory()->create([
            "name" => "Tonmoy",
            "email" => "tonmoy@email.com",
        ]);

        Todo::factory()->create();
        $user2Todo = Todo::factory()->create([
            "name" => "user 2 todo",
            "user_id" => $user2->id,
        ]);

        $response = $this->actingAs($user, 'sanctum')->delete('api/todos/' . $user2Todo->id);
        $response->assertStatus(Response::HTTP_NOT_FOUND);
//        dd($response->getContent());

        $response->assertJson([
            "status" => Response::HTTP_NOT_FOUND,
            "success" => false,
            "error" => "Todo not found",
        ]);

        $this->assertDatabaseHas('todos', [
            "name" => $user2Todo->name,
            "id" => $user2Todo->id,
        ]);
    }





}
