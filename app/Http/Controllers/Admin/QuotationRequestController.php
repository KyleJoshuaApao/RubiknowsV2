<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesSubmissions;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReplyQuotationRequest;
use App\Http\Requests\Admin\UpdateQuotationRequest;
use App\Models\QuotationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QuotationRequestController extends Controller
{
    use HandlesSubmissions;

    public function index()
    {
        $quotations = QuotationRequest::latest()->paginate(15);

        return view('admin.quotations.index', compact('quotations'));
    }

    public function show(QuotationRequest $quotation)
    {
        $engineers = User::whereIn('role', User::ADMIN_ROLES)->orderBy('name')->get(['id', 'name']);

        return view('admin.quotations.show', compact('quotation', 'engineers'));
    }

    public function update(UpdateQuotationRequest $request, QuotationRequest $quotation)
    {
        $quotation->update($request->validated());

        return back()->with('success', 'Quotation request updated successfully.');
    }

    public function destroy(QuotationRequest $quotation)
    {
        $quotation->deleteAttachments();
        $quotation->delete();

        return redirect()->route('admin.quotations.index')->with('success', 'Quotation request deleted.');
    }

    public function bulkDestroy(Request $request)
    {
        return $this->bulkDelete($request, QuotationRequest::class, 'admin.quotations.index', 'quotation requests');
    }

    public function reply(ReplyQuotationRequest $request, QuotationRequest $quotation)
    {
        return $this->sendReply($quotation, $request->validated(), 'Update on your Quotation Request at RUBIKNOWS');
    }

    public function downloadAttachment(QuotationRequest $quotation)
    {
        $disk = $quotation->attachmentDisk();
        abort_unless($disk, 404);

        return Storage::disk($disk)->download($quotation->attachment_path);
    }

    public function downloadFile(QuotationRequest $quotation, int $index)
    {
        return $this->downloadSubmissionFile($quotation, $index);
    }
}
