<?php
namespace App\Http\Controllers\Api\HouseOwner;

use App\Http\Controllers\Controller;
use App\Jobs\SendBillCreatedEmail;
use App\Models\Bill;
use App\Models\Flat;
use Illuminate\Http\Request;

class BillController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Bill::class);

        $validated = $request->validate([
            'flat_id'          => 'required|exists:flats,id',
            'bill_category_id' => 'required|exists:bill_categories,id',
            'amount'           => 'required|numeric',
            'month'            => 'required|date_format:Y-m-d',
        ]);

        $flat = Flat::findOrFail($validated['flat_id']);
        $this->authorize('view', $flat); // Ensure flat belongs to tenant

        $bill = Bill::create([
             ...$validated,
            'status' => 'pending',
        ]);

        // Dispatch email job
        if ($flat->tenant) {
            SendBillCreatedEmail::dispatch($bill, $flat->tenant);
        }

        return $bill->load(['flat', 'category']);
    }

    public function updateStatus(Request $request, Bill $bill)
    {
        $this->authorize('update', $bill);

        $request->validate([
            'status' => 'required|in:paid',
        ]);

        $bill->update(['status' => 'paid']);

        // Dispatch paid email
        SendBillPaidEmail::dispatch($bill);

        return $bill;
    }

    public function index()
    {
        $this->authorize('viewAny', Bill::class);

        return Bill::with(['flat:id,flat_number', 'category:id,name'])
            ->orderBy('month', 'desc')
            ->paginate(50);
    }
}
