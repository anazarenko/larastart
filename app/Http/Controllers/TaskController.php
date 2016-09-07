<?php

namespace App\Http\Controllers;

use App\Repositories\TaskRepository;
use App\Task;
use Illuminate\Http\Request;

use App\Http\Requests;

class TaskController extends Controller
{
    /**
     * Экземпляр TaskRepository.
     *
     * @var TaskRepository
     */
    protected $tasks;

    /**
     * Создание нового экземпляра контроллера.
     *
     * TaskController constructor.
     * @param TaskRepository $tasks
     */
    public function __construct(TaskRepository $tasks)
    {
        $this->middleware('auth');

        $this->tasks = $tasks;
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view(
            'tasks.index',
            ['tasks' => $this->tasks->forUser($request->user())]
        );
    }

    /**
     * Создание новой задачи.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $request->user()->tasks()->create([
            'name' => $request->name,
        ]);

        return redirect('/tasks');
    }

    /**
     * Уничтожить заданную задачу.
     *
     * @param Request $request
     * @param Task $task
     */
    public function destroy(Request $request, Task $task)
    {
        //
    }
}
