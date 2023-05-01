<?php

namespace App\Http\Controllers;

use App\Http\Filters\TaskFilter;
use App\Http\Requests\Task\StoreRequest;
use App\Http\Requests\Task\UpdateRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $filter = app()->make(TaskFilter::class, ['queryParams' => array_filter($data)]);

        // Используется шаблон Filter
        // Смотри класс TaskFilter, там заданы колбэки для фильтрации по статусу и тексту
        $tasks = Task::filter($filter)->get();

        return new JsonResource($tasks);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function store(StoreRequest $request)
    {
        $validated = $request->validated();

        $task = Task::create([
            'text' => $validated['text'],
            'engineer_id' => $validated['engineer_id']
        ]);

        return new JsonResource($task);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show(Task $task)
    {
        return new JsonResource($task);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource|\Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, Task $task)
    {
        $validated = $request->validated();

        $fields = ['text', 'engineer_id', 'status_id'];

        foreach ($fields as $item) {
            if (!\array_key_exists($item, $validated)) {
                return response()->json(['message' => 'Invalid request'], 400);
            }
        }

        $task->update([
            'text' => $validated['text'],
            'engineer_id' => $validated['engineer_id'],
            'status_id' => $validated['status_id'],
        ]);

        return new JsonResource($task);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return new JsonResource($task);
    }
}
