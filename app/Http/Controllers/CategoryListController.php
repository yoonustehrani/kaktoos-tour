<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryListController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'classification_id' => 'integer|exists:classifications,id'
        ]);
        $query = Category::query();
        if ($request->query('classification_id')) {
            $query->where('classification_id', $request->query('classification_id'));
        }
        return response()->json(
            CategoryResource::collection($query->get())
        );
    }
}
