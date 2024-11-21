<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $isDashboard = $request->input('is_dashboard', false);

        if ($isDashboard) {
            if ($user->isAdmin()) {
                $tasksQuery = Task::query();
            } else {
                $tasksQuery = Task::where('author', $user->id);
            }

            $tasks = $tasksQuery->get();
        } else {
            if ($user->isAdmin()) {
                $tasksQuery = Task::query();
            } else {
                $tasksQuery = Task::where('author', $user->id);
            }

            $tasks = $tasksQuery->paginate(10);
        }

        if ($tasks->isEmpty()) {
            return response()->json(['message' => 'Nenhuma tarefa encontrada'], 404);
        }

        return response()->json($tasks);
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:pendente,em andamento,concluída',
        ]);

        $task = Task::create([
            'author' => Auth::id(),
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => $validated['status'],
        ]);

        return response()->json(['task' => $task, 'message' => 'Tarefa criada com sucesso.'], 201);
    }
    public function show(string $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['message' => 'Tarefa não encontrada'], 404);
        }

        return response()->json($task);
    }
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:pendente,em andamento,concluída',
        ]);

        $task = Task::findOrFail($id);
        $user = Auth::user();
        if (!$user->isAdmin() && $task->author !== Auth::id()) {
            return response()->json(['error' => 'Você não tem permissão para editar esta tarefa.'], 403);
        }

        $task->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => $validated['status'],
        ]);

        return response()->json($task);
    }

    public function destroy(string $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(['message' => 'Tarefa não encontrada'], 404);
        }

        $task->delete();

        return response()->json(['message' => 'Tarefa deletada com sucesso']);
    }
}
