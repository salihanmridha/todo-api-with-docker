<?php

namespace App\Repositories;

use App\Repositories\Contracts\TodoRepositoryInterface;
use App\Repositories\BaseRepository;
use App\Models\Todo;

class TodoRepository extends BaseRepository implements TodoRepositoryInterface
{
    /**
     * Todos repository constructor.
     *
     * @param Todo $todo
     */
    public function __construct(Todo $todo)
    {
        parent::__construct($todo);

        $this->model = $todo;
    }
}
