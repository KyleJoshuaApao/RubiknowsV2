<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReplyQuotationRequest;
use App\Http\Requests\Admin\UpdateQuotationRequest;
use App\Mail\AdminReplyNotification;
use App\Models\QuotationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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
        $engineers = User::all();

        return view('admin.quotations.show', compact('quotation', 'engineers'));
    }

    public function update(UpdateQuotationRequest $request, QuotationRequest $quotation)
    {
        $data = $request->validated();

        $quotation->update($data);

        return back()->with('success', 'Quotation request updated successfully.');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);
        if (! empty($ids)) {
            QuotationRequest::whereIn('id', $ids)->delete();

            return redirect()->route('admin.quotations.index')->with('success', 'Selected quotation requests deleted successfully.');
        }

        return redirect()->route('admin.quotations.index')->with('error', 'No quotation requests selected.');
    }

    public function reply(ReplyQuotationRequest $request, QuotationRequest $quotation)
    {
        $data = $request->validated();

        $updateData = [
            'reply_message' => $data['reply_message'],
            'replied_at' => now(),
        ];

        // Only update status if provided in request
        if ($data['status'] !== null) {
            $updateData['status'] = $data['status'];
        }

        $quotation->update($updateData);

        try {
            $subject = 'Update on your Quotation Request at RubiKnows';
            $senderName = $data['sender_name'] ?? 'The RubiKnows Team';
            Mail::to($quotation->email)->send(new AdminReplyNotification($quotation->name, $data['reply_message'], $subject, $senderName));
        } catch (\Exception $e) {
            Log::error('Mail Error (Reply): '.$e->getMessage());

            return back()->with('error', 'Reply saved, but email could not be sent.');
        }

        return back()->with('success', 'Reply sent successfully.');
    }
}
