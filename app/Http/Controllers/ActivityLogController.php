<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $logs = ActivityLog::with('user')->latest()->get();

        return response()->json($logs);
    }
}