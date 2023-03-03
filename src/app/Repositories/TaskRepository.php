<?php

namespace App\Repositories;

use App\Repositories\Contracts\TaskRepositoryInterface;
use App\Repositories\BaseRepository;
use App\Models\Task;

class TaskRepository extends BaseRepository implements TaskRepositoryInterface
{
    /**
     * Todos repository constructor.
     *
     * @param Task $task
     */
    public function __construct(Task $task)
    {
        parent::__construct($task);

        $this->model = $task;
    }
}
