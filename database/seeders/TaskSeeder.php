<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\User;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('email', 'admin@example.com')->first();
        $staff = User::where('email', 'staff@example.com')->first();

        Task::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'title' => 'Contoh Task Pertama',
            'description' => 'Task contoh yang dibuat oleh admin',
            'assigned_to' => $staff->id,
            'status' => 'pending',
            'due_date' => now()->addDays(3),
            'created_by' => $admin->id,
        ]);
    }
}

