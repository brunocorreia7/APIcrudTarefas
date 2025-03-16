<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

/**
 * @OA\Info(title="API de Tarefas", version="1.0")
 */
class TaskController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/tasks",
     *     summary="Listar todas as tarefas",
     *     @OA\Response(
     *         response=200,
     *         description="Lista de tarefas"
     *     )
     * )
     */
    public function index() {
        return response()->json(Task::all(), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/tasks",
     *     summary="Criar uma nova tarefa",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title"},
     *             @OA\Property(property="title", type="string", example="Nova Tarefa"),
     *             @OA\Property(property="description", type="string", example="Descrição da nova tarefa"),
     *             @OA\Property(property="completed", type="boolean", example=false)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Tarefa criada"
     *     )
     * )
     */
    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'completed' => 'boolean',
        ]);

        $task = Task::create($request->all());
        return response()->json($task, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/tasks/{id}",
     *     summary="Obter detalhes de uma tarefa",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalhes da tarefa"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tarefa não encontrada"
     *     )
     * )
     */
    public function show($id) {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }
        return response()->json($task, 200);
    }

    /**
     * @OA\Put(
     *     path="/api/tasks/{id}",
     *     summary="Atualizar uma tarefa",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="Tarefa Atualizada"),
     *             @OA\Property(property="description", type="string", example="Descrição atualizada"),
     *             @OA\Property(property="completed", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tarefa atualizada"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tarefa não encontrada"
     *     )
     * )
     */
    public function update(Request $request, $id) {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'completed' => 'boolean',
        ]);

        $task->update($request->all());
        return response()->json($task, 200);
    }

    /**
     * @OA\Delete(
     *     path="/api/tasks/{id}",
     *     summary="Deletar uma tarefa",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Tarefa deletada"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Tarefa não encontrada"
     *     )
     * )
     */
    public function destroy($id) {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $task->delete();
        return response()->json(['message' => 'Task deleted'], 200);
    }
}
