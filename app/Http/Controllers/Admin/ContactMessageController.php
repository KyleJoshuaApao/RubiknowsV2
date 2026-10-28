<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\HandlesSubmissions;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ReplyContactMessageRequest;
use App\Http\Requests\Admin\UpdateContactMessageRequest;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    use HandlesSubmissions;

    public function index()
    {
        $messages = ContactMessage::latest()->paginate(15);

        return view('admin.messages.index', compact('messages'));
    }

    public function show(ContactMessage $message)
    {
        return view('admin.messages.show', compact('message'));
    }

    public function update(UpdateContactMessageRequest $request, ContactMessage $message)
    {
        $message->update(['status' => $request->validated('status')]);

        return back()->with('success', 'Message status updated.');
    }

    public function downloadAttachment(ContactMessage $message, int $index)
    {
        return $this->downloadSubmissionFile($message, $index);
    }

    public function destroy(ContactMessage $message)
    {
        $message->deleteAttachments();
        $message->delete();

        return redirect()->route('admin.messages.index')->with('success', 'Message deleted.');
    }

    public function bulkDestroy(Request $request)
    {
        return $this->bulkDelete($request, ContactMessage::class, 'admin.messages.index', 'messages');
    }

    public function reply(ReplyContactMessageRequest $request, ContactMessage $message)
    {
        $subject = 'Re: '.($message->subject ?: 'Your inquiry at RubiKnows');

        return $this->sendReply($message, $request->validated(), $subject);
    }
}
