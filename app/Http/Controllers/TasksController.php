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
