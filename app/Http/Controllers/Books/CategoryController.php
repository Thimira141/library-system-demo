<?php

namespace App\Http\Controllers\Books;

use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
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
     * searching categories for data table in manage categories page
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author Thimira Dilshan <thimirad865@gmail.com>
     */
    public function searchCategoriesAJAX(Request $request)
    {
        // Build query with book count
        $query = Category::withCount('books')
            ->addSelect(['id', 'category_name', 'category_remarks'])
            ->get();
        // Return DataTables response
        return DataTables::of($query)->make(true);
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
