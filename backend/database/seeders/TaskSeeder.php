<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run()
    {
        for ($i = 0; $i < 40; $i++) {
            $userId = rand(1, 5);

            Task::create([
                'author' => User::all()->pluck('id')[$userId],
                'title' => 'Título da Tarefa ' . ($i + 1),
                'description' => 'Descrição da tarefa ' . ($i + 1),
                'status' => collect(['pendente', 'em andamento', 'concluída'])->random(),
            ]);
        }
    }
}
