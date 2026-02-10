<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    public function index()
    {
        return view("calendar.index");
    }

    public function getEvents(Request $request)
    {
        $start = (!empty($request->start)) ? date("Y-m-d", strtotime($request->start)) : (
            !empty($request->startStr) ? date("Y-m-d", strtotime($request->startStr)) : null
        );
        $end = (!empty($request->end)) ? date("Y-m-d", strtotime($request->end)) : (
            !empty($request->endStr) ? date("Y-m-d", strtotime($request->endStr)) : null
        );

        $tasks = Task::where("due_date", ">=", $start)
            ->where("due_date", "<=", $end)
            ->whereIn(
                "project_id",
                Auth::user()->projects->pluck("id")
            )
            ->get();

        $events = [];
        foreach ($tasks as $task) {
            $className = "";
            if ($task->due_date->isToday()) {
                $className = "bg-atlvs-cyan text-black";
            } elseif ($task->due_date->isPast() && !$task->status == "completed") {
                $className = "bg-red-500 text-white";
            } elseif ($task->due_date->diffInDays(now()) <= 3) {
                $className = "bg-yellow-500 text-black";
            }

            $events[] = [
                "id" => $task->id,
                "title" => $task->title,
                "start" => $task->due_date->format("Y-m-d"),
                "url" => route("projects.show", $task->project_id),
                "className" => $className,
            ];
        }

        return response()->json($events);
    }
}
