<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Category\CategoryCollection;

class CategoryController extends Controller
{
    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    public function index(Request $request) 
    {
    	if ($request->has('rowsPerPage')) {
            $rowsPerPage = $request->input('rowsPerPage');
        }

        $categories = $this->category->orderBy('id', 'DESC');

        if ($request->has('filter')) {
            $filter = $request->input('filter');

            $categories = $categories->where(function ($query) use ($filter) {
                $query->where('name', 'LIKE', "%" . $filter . "%");
            });
        }

        $categories = $categories->paginate($rowsPerPage);
    	return new CategoryCollection($categories); 
    }

    public function show($id)
    {
        $category = $this->category->findOrFail($id);
        return new CategoryResource($category); 
    }

    public function store(CategoryRequest $request)
    {
        try {
            $this->category->create($request->all());
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondCreated();
    }

    public function update(CategoryRequest $request, $id)
    {
        try {
            $category = $this->category->find($id);
            $category->update($request->all());
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondUpdated();
    }

    public function destroy($id)
    {
        try {
            $category = $this->category::find($id);
            $category->delete();
        } catch (\Exception $e) {
            return $this->respondInternalError();
        }
        return $this->respondDeleted();
    }

    public function listing()
    {
    	$categories = $this->category->listProjectTypes();
        return $this->respond($categories);
    }
}
