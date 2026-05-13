<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskImage;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;

class TaskImageController extends Controller
{
    use AuthorizesRequests;

    public function store(Request $request, Task $task)
    {
        $request->validate([
            'images'   => 'required|array',
            'images.*' => 'image|max:2048',
        ]);

        $isFirst = $task->images()->count() === 0;
        $uploaded = [];

        foreach ($request->file('images') as $image) {
            $path = $image->store('task-images', 'public');

            $taskImage = $task->images()->create([
                'path'     => $path,
                'is_cover' => $isFirst,
            ]);

            $uploaded[] = [
                'id'       => $taskImage->id,
                'url'      => asset('storage/' . $path),
                'is_cover' => $isFirst,
            ];

            $isFirst = false;
        }

        return response()->json(['success' => true, 'images' => $uploaded]);
    }

    public function setCover(TaskImage $image)
    {
        $image->task->images()->update(['is_cover' => false]);
        $image->update(['is_cover' => true]);

        return back()->with('success', 'Cover image updated!');
    }

    public function destroy(TaskImage $image)
    {
        Storage::disk('public')->delete($image->path);
        $image->delete();

        return back()->with('success', 'Image deleted!');
    }
}
