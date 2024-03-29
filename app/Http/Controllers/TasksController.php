<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;

class TasksController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index(Request $request)
    {
        $limit = $request->limit;
        $sort = $request->sort;
        $order = $request->order;

        $tasks = Task::where('user_id', auth()->user()->id)->orderBy($sort, $order)->paginate($limit);

        foreach ($tasks as $task) {
            $timeAdded = $task->created_at->diffForHumans();
            $user = $task->user->name;
            echo "$task->body added at $timeAdded by $user\n";
        }
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'body' => 'required',
        ]);


        auth()->user()->tasks()->create($request->only('body'));

        $userName = auth()->user()->name;
        echo "task added by {$userName}";
    }
}
