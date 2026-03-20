<?php

namespace App\Http\Controllers\Books;

use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function createCategoryView()
    {
        // $category = null;
        $pageData = ['edit' => false, 'title' => 'Create New Category'];
        return view('categories.category-form', compact('pageData'));
    }

    public function EditCategoryView($id)
    {
        $category = Category::findOrFail($id);
        $pageData = ['edit' => true, 'title' => 'Edit Category'];
        return view('categories.category-form', compact('category', 'pageData'));
    }

    //
    public function createCategoryAJAX(Request $request)
    {
        // validate data
        $validate = $this->ValidateData($request);
        // handle validate fail response
        if ($validate->fails()) {
            return response()->json([
                'status' => 'validateFail',
                'message' => 'Data Validate Failed!',
                'errorBag' => $validate->errors()
            ], 422);
        }
        try {
            // create category
            $validated = $validate->validated();
            $category = Category::create([
                'category_name' => $validated['category_name'],
                'category_remarks' => $validated['category_remarks']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Database error occurred.',
                'error' => $e->getMessage()
            ], 500);
        }
        // return response
        return response()->json([
            'status' => 'success',
            'message' => 'Category created successfully!',
            // 'category' => $category->toArray(),
            'redirect' => route('categories-edit-view', $category->id)
        ], 200);
    }

    public function editCategoryAJAX(Request $request, $id)
    {
        $validate = $this->ValidateData($request, $id);
        // handle validate fail response
        if ($validate->fails()) {
            return response()->json([
                'status' => 'validateFail',
                'message' => 'Data Validate Failed!',
                'errorBag' => $validate->errors()
            ], 422);
        }
        $validated = $validate->validated();
        try {
            // get model
            $category = Category::firstOrFail('id', $id);
            // assign new data
            $category->category_name = $validated['category_name'];
            $category->category_remarks = $validated['category_remarks'];
            // save
            $category->save();
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Database error occurred.',
                'error' => $e->getMessage()
            ], 500);
        }
        // return response
        return response()->json([
            'status' => 'success',
            'message' => 'Category updated successfully!',
            // 'category' => $category->toArray()
        ], 200);
    }

    public function deleteCategory_permanent(Request $request, $id)
    {
        $validate = Validator::make(
            $request->all(),
            ['id' => 'required|string|exists:categories,id'],
            [],
            ['id' => 'BookID']
        );
        if ($validate->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 'validateFail',
                    'errorBag' => $validate->errors()->toArray(),
                    'message' => 'Data validation failed!',
                ], 401);
            }
            return back()->withErrors($validate->errors()->toArray());
        }
        $validated = $validate->validated();
        try {
            $category = Category::where('id', $validated['id'])->firstOrFail();
            // Remove all book associations first
            $category->books()->detach();
            // delete the category itself
            $category->delete();
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'File delete failed.',
                'error' => $e->getMessage()
            ], 500);
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Category deleted successfully.'
        ]);

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

    private function ValidateData(Request $request, int|bool $id = false, array $rules = [], array $attributes = [])
    {
        $rules = [
            'category_name' => [
                'required',
                'string',
                'min:4',
                'max:200',
                $id !== false
                ? Rule::unique('categories', 'category_name')->ignore($id, 'id') // update mode
                : Rule::unique('categories', 'category_name'), // create mode
            ],
            'category_remarks' => ['nullable', 'string', 'max:200'],
            ...$rules
        ];
        $attributes = ['category_name' => 'Category name', 'category_remarks' => 'Remarks', ...$attributes];
        // return validator
        return Validator::make($request->all(), $rules, [], $attributes);
    }
}
