<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Task;
use Carbon\Carbon;

class TaskLogicTest extends TestCase
{
    public function test_task_is_overdue()
    {
        // Buat task dengan tanggal kemarin
        $task = new Task([
            'title' => 'Contoh Tugas',
            'description' => 'Deskripsi',
            'due_date' => Carbon::yesterday()->toDateString(),
        ]);

        $this->assertEquals('overdue', $task->status);
    }

    public function test_task_not_overdue()
    {
        $task = new Task([
            'title' => 'Contoh Tugas',
            'description' => 'Deskripsi',
            'due_date' => Carbon::tomorrow()->toDateString(),
        ]);

        $this->assertNotEquals('overdue', $task->status);
    }
}
