<?php

namespace App\Http\Controllers;

use App\Http\Filters\EngineerFilter;
use App\Http\Requests\Engineer\StoreRequest;
use App\Http\Requests\Engineer\UpdateRequest;
use App\Models\Engineer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EngineerController extends Controller
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
        $filter = app()->make(EngineerFilter::class, ['queryParams' => array_filter($data)]);

        // Используется шаблон Filter
        // Смотри класс EngineerFilter, там заданы колбэки для фильтрации по имени и фамилии
        $engineers = Engineer::filter($filter)->get();

        return new JsonResource($engineers);
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

        $task = Engineer::create([
            'name' => $validated['name'],
            'surname' => $validated['surname'],
            'phone' => $validated['phone'],
            'email' => $validated['email']
        ]);

        return new JsonResource($task);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Engineer  $engineer
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function show(Engineer $engineer)
    {
        return new JsonResource($engineer);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Engineer  $engineer
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Engineer $engineer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Engineer  $engineer
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource|\Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, Engineer $engineer)
    {
        $validated = $request->validated();

        $fields = ['name', 'surname', 'phone', 'email'];

        foreach ($fields as $item) {
            if (!\array_key_exists($item, $validated)) {
                return response()->json(['message' => 'Invalid request'], 400);
            }
        }

        $engineer->update([
            'name' => $validated['name'],
            'surname' => $validated['surname'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
        ]);

        return new JsonResource($engineer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Engineer  $engineer
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
     */
    public function destroy(Engineer $engineer)
    {
        $engineer->delete();

        return new JsonResource($engineer);
    }
}
