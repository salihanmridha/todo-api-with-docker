<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Unauthenticated user cant create task and redirect to login get route
     */
    public function test_unauthenticated_user_cant_create_task(): void
    {
        $attr = [
            "name" => "task name",
        ];
        $response = $this->post('api/tasks', $attr);

        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect("api/login");

    }

    /**
     * Unauthenticated user cant access single tasks and redirect to login get route
     */
    public function test_unauthenticated_user_cant_get_single_task(): void
    {
        $response = $this->get('api/tasks/1');

        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect("api/login");
    }

    /**
     * Unauthenticated user cant update tasks and redirect to login get route
     */
    public function test_unauthenticated_user_cant_update_task(): void
    {
        $attr = [
            "name" => "task name",
        ];
        $response = $this->put('api/tasks/1', $attr);

        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect("api/login");
    }

    /**
     * Unauthenticated user cant delete tasks and redirect to login get route
     */
    public function test_unauthenticated_user_cant_delete_task(): void
    {
        $response = $this->delete('api/tasks/1');

        $response->assertStatus(Response::HTTP_FOUND);
        $response->assertRedirect("api/login");
    }

    //authenticate user test cases start here

    /**
     * authenticated user can create task
     */
    public function test_authenticated_user_can_create_task(): void
    {
        $user = User::factory()->create();

        $todo = Todo::factory()->create();

        $attr = [
            "name" => "task name",
            "todo_id" => $todo->id,
        ];
        $response = $this->actingAs($user, 'sanctum')->post('api/tasks', $attr);
        $response->assertStatus(Response::HTTP_CREATED);
//        dd($response->getContent());
        $response->assertJson([
            "status" => Response::HTTP_CREATED,
            "success" => true,
            "message" => "Task created successfully",
            "data" => [
                "name" => $attr["name"],
                "todo_id" => $attr["todo_id"],
            ],
        ]);

        $this->assertDatabaseHas('tasks', [
            "name" => $attr["name"],
            "todo_id" => $attr["todo_id"],
        ]);
    }

    /**
     * authenticated user can not create task of other user todo
     */
    public function test_authenticated_user_cant_create_task_of_other_user_todo(): void
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
            "name" => "task name",
            "todo_id" => $user2Todo->id,
        ];
        $response = $this->actingAs($user, 'sanctum')->post('api/tasks', $attr);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
//        dd($response->getContent());
        $response->assertJson([
            "status" => Response::HTTP_FORBIDDEN,
            "success" => false,
            "error" => "You dont have permission to create task under this todo.",
        ]);

        $this->assertDatabaseMissing('tasks', [
            "name" => $attr["name"],
            "todo_id" => $attr["todo_id"],
        ]);
    }

    /**
     * authenticated user can view task with todo
     */
    public function test_authenticated_user_can_view_task_with_todo(): void
    {
        $user = User::factory()->create();

        Todo::factory()->create();
        Task::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->get('api/tasks/1');
        $response->assertStatus(Response::HTTP_OK);
//        dd($response->getContent());
        $response->assertJson([
            "status" => Response::HTTP_OK,
            "success" => true,
            "data" => [
                "todo" => []
            ],
        ]);
    }

    /**
     * authenticated user can view task with todo
     */
    public function test_authenticated_user_cant_view_task_of_other_user_todo(): void
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

        $task = Task::factory()->create([
            "name" => "task name",
            "todo_id" => $user2Todo->id,
        ]);

        $response = $this->actingAs($user, 'sanctum')->get('api/tasks/' . $task->id);
        $response->assertStatus(Response::HTTP_FORBIDDEN);
//        dd($response->getContent());
        $response->assertJson([
            "status" => Response::HTTP_FORBIDDEN,
            "success" => false,
            "error" => 'You dont have permission to view this task.',
        ]);
    }

    /**
     * authenticated user can update task
     */
    public function test_authenticated_user_can_update_task(): void
    {
        $user = User::factory()->create();

        Todo::factory()->create();
        Task::factory()->create();

        $attr = [
            "name" => "updated task name",
        ];
        $response = $this->actingAs($user, 'sanctum')->put('api/tasks/1', $attr);
        $response->assertStatus(Response::HTTP_ACCEPTED);
//        dd($response->getContent());

        $response->assertJson([
            "status" => Response::HTTP_ACCEPTED,
            "success" => true,
            "message" => "Task name updated successfully",
            "data" => [
                "name" => $attr["name"],
                "todo" => []
            ],
        ]);

        $this->assertDatabaseHas('tasks', [
            "name" => $attr["name"],
        ]);
    }

    /**
     * authenticated user can delete task
     */
    public function test_authenticated_user_can_delete_task(): void
    {
        $user = User::factory()->create();

        Todo::factory()->create();
        $task = Task::factory()->create();

        $response = $this->actingAs($user, 'sanctum')->delete('api/tasks/1');
        $response->assertStatus(Response::HTTP_ACCEPTED);
//        dd($response->getContent());

        $response->assertJson([
            "status" => Response::HTTP_ACCEPTED,
            "success" => true,
            "message" => $task->name . " task deleted successfully",
        ]);

        $this->assertDatabaseMissing('tasks', [
            "name" => $task->name,
        ]);
    }
}
