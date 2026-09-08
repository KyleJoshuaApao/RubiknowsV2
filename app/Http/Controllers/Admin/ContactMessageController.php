<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminReplyNotification;

class ContactMessageController extends Controller
{
    public function index()
    {
        $messages = ContactMessage::latest()->paginate(15);
        return view('admin.messages.index', compact('messages'));
    }

    public function show(ContactMessage $message)
    {
        if ($message->status === 'New') {
            $message->update(['status' => 'Read']);
        }
        
        return view('admin.messages.show', compact('message'));
    }

    public function update(Request $request, ContactMessage $message)
    {
        $request->validate([
            'status' => 'required|in:New,Read,Replied,Archived,Spam'
        ]);

        $message->update(['status' => $request->status]);
        return back()->with('success', 'Message status updated.');
    }

    public function destroy(ContactMessage $message)
    {
        $message->delete();
        return redirect()->route('admin.messages.index')->with('success', 'Message deleted.');
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);
        if (!empty($ids)) {
            ContactMessage::whereIn('id', $ids)->delete();
            return redirect()->route('admin.messages.index')->with('success', 'Selected messages deleted successfully.');
        }
        return redirect()->route('admin.messages.index')->with('error', 'No messages selected.');
    }

    public function reply(Request $request, ContactMessage $message)
    {
        $data = $request->validate([
            'reply_message' => 'required|string|max:5000',
            'sender_name' => 'nullable|string|max:255',
        ]);

        $message->update([
            'reply_message' => $data['reply_message'],
            'replied_at' => now(),
            'status' => 'Replied',
        ]);

        try {
            $subject = 'Re: ' . ($message->subject ?: 'Your inquiry at RubiKnows');
            $senderName = $data['sender_name'] ?? 'The RubiKnows Team';
            Mail::to($message->email)->send(new AdminReplyNotification($message->name, $data['reply_message'], $subject, $senderName));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Mail Error (Reply): ' . $e->getMessage());
            return back()->with('error', 'Reply saved, but email could not be sent.');
        }

        return back()->with('success', 'Reply sent successfully.');
    }
}
