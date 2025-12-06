<?php
namespace App\Http\Controllers\Api\HouseOwner;

use App\Http\Controllers\Controller;
use App\Models\BillCategory;
use Illuminate\Http\Request;

class BillCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    /**
     * Display all bill categories for the authenticated house owner
     */
    public function index()
    {
        $this->authorize('viewAny', BillCategory::class);

        return BillCategory::orderBy('name')
            ->paginate(50);
    }

    /**
     * Store a new bill category
     */
    public function store(Request $request)
    {
        $this->authorize('create', BillCategory::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:bill_categories,name',
        ]);

        // Tenant_id is automatically set by TenantModel base class
        $category = BillCategory::create([
            'name' => $validated['name'],
        ]);

        return response()->json($category, 201);
    }

    /**
     * Display a specific bill category
     */
    public function show(BillCategory $billCategory)
    {
        $this->authorize('view', $billCategory);

        return $billCategory;
    }

    /**
     * Update a bill category
     */
    public function update(Request $request, BillCategory $billCategory)
    {
        $this->authorize('update', $billCategory);

        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255|unique:bill_categories,name,' . $billCategory->id,
        ]);

        $billCategory->update($validated);

        return response()->json([
            'message' => 'Category updated successfully',
            'data'    => $billCategory,
        ]);
    }

    /**
     * Delete a bill category
     */
    public function destroy(BillCategory $billCategory)
    {
        $this->authorize('delete', $billCategory);

        // Check if category is in use
        if ($billCategory->bills()->exists()) {
            return response()->json([
                'error' => 'Cannot delete category that is in use by bills',
            ], 422);
        }

        $billCategory->delete();

        return response()->json(['message' => 'Category deleted successfully']);
    }
}
