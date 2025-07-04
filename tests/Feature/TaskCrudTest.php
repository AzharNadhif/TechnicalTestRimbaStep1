<?php

 namespace Tests\Feature;

use App\Models\User;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskCrudTest extends TestCase
{
        use RefreshDatabase;

        public function test_admin_can_create_task()
        {
            $admin = User::factory()->create(['role' => 'admin']);
            $staff = User::factory()->create(['role' => 'staff']);

            $this->actingAs($admin, 'sanctum');

            $response = $this->postJson('/api/tasks', [
                'title' => 'Tugas Baru',
                'description' => 'Deskripsi tugas',
                'due_date' => now()->addDays(3)->toDateString(),
                'assigned_to' => $staff->id
            ]);

            $response->assertStatus(201);
            $this->assertDatabaseHas('tasks', ['title' => 'Tugas Baru']);
        }

        public function test_staff_cannot_create_task()
        {
            $staff = User::factory()->create(['role' => 'staff']);

            $this->actingAs($staff, 'sanctum');

            $response = $this->postJson('/api/tasks', [
                'title' => 'Tugas Ilegal',
                'description' => 'Seharusnya tidak boleh',
                'due_date' => now()->addDays(2)->toDateString(),
                'assigned_to' => $staff->id
            ]);

            $response->assertStatus(403); // Forbidden
        }
    }
