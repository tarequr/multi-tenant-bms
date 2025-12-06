<?php
namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Flat;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    public function index()
    {
        $this->authorize('viewAny', Flat::class);

        return Flat::with(['tenant:id,name', 'bills:flat_id,status,amount'])
            ->paginate(50);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Flat::class);

        $validated = $request->validate([
            'flat_number' => 'required|unique:flats,flat_number',
            'floor'       => 'nullable|integer',
            'status'      => 'in:vacant,occupied',
        ]);

        $validated['house_owner_id'] = auth()->id();

        return Flat::create($validated);
    }

    public function update(Request $request, Flat $flat)
    {
        $this->authorize('update', $flat);

        $validated = $request->validate([
            'flat_number' => 'sometimes|required',
            'status'      => 'sometimes|in:vacant,occupied',
        ]);

        $flat->update($validated);
        return $flat;
    }

    public function destroy(Flat $flat)
    {
        $this->authorize('delete', $flat);

        $flat->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
