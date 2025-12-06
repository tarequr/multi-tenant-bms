<?php
namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class HouseOwnerController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', User::class);

        return User::where('role', 'house_owner')->get();
    }

    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        $validated = $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        $validated['password']  = Hash::make($validated['password']);
        $validated['role']      = 'house_owner';
        $validated['tenant_id'] = Str::uuid();
        $validated['id']        = Str::uuid();

        return User::create($validated);
    }
}
