<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuotationRequest;
use App\Models\User;
use Illuminate\Http\Request;

class QuotationRequestController extends Controller
{
    public function index()
    {
        $quotations = QuotationRequest::latest()->paginate(15);
        $engineers = User::all();
        return view('admin.quotations.index', compact('quotations', 'engineers'));
    }

    public function show(QuotationRequest $quotation)
    {
        if ($quotation->status === 'Pending') {
            $quotation->update(['status' => 'Under Review']);
        }
        $engineers = User::all();
        
        return view('admin.quotations.show', compact('quotation', 'engineers'));
    }

    public function update(Request $request, QuotationRequest $quotation)
    {
        $request->validate([
            'status' => 'sometimes|required|in:Pending,Under Review,Estimated,Sent,Closed',
            'assigned_engineer_id' => 'nullable|exists:users,id'
        ]);

        $quotation->update($request->only(['status', 'assigned_engineer_id']));
        return back()->with('success', 'Quotation request updated.');
    }

    public function destroy(QuotationRequest $quotation)
    {
        $quotation->delete();
        return redirect()->route('admin.quotations.index')->with('success', 'Quotation request deleted.');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            QuotationRequest::whereIn('id', $ids)->delete();
            return redirect()->route('admin.quotations.index')->with('success', 'Selected quotation requests deleted successfully.');
        }
        return redirect()->route('admin.quotations.index')->with('error', 'No quotation requests selected.');
    }
}
