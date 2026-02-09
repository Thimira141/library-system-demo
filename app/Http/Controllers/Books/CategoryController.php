<?php

namespace App\Http\Controllers\Books;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function createCategory()
    {
        // code...
    }

    /**
     *
     * send categories info to tom-select
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author Thimira Dilshan <thimirad865@gmail.com>
     */
    public function getCategory(Request $request)
    {
        $search = $request->input('q');
        $query = Category::query();
        if ($search) {
            $query->where('category_name', 'like', "%{$search}%");
        }
        $categories = $query->select(['id', 'category_name'])->limit(20)->get();
        return response()->json($categories);
    }
}
