<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class MaterialController extends Controller
{
    public function download(Material $material)
    {
        Gate::authorize('view', $material);

        if (!$material->file_path || !Storage::disk('public')->exists($material->file_path)) {
            abort(404, 'File not found');
        }

        return Storage::disk('public')->download(
            $material->file_path,
            $material->title . '.' . pathinfo($material->file_path, PATHINFO_EXTENSION)
        );
    }

    public function preview(Material $material)
    {
        Gate::authorize('view', $material);

        if (!$material->file_path || !Storage::disk('public')->exists($material->file_path)) {
            abort(404, 'File not found');
        }

        $filePath = Storage::disk('public')->path($material->file_path);
        $extension = strtolower(pathinfo($material->file_path, PATHINFO_EXTENSION));

        if (in_array($extension, ['pdf'])) {
            return response()->file($filePath, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $material->title . '.pdf"',
            ]);
        }

        if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            return response()->file($filePath);
        }

        return Storage::disk('public')->download($material->file_path);
    }
}
