<?php

namespace App\Http\Controllers\Admin\Concerns;

use App\Mail\AdminReplyNotification;
use App\Support\PublicContentCache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Shared admin actions for inbound submissions (messages, quotations, applications).
 */
trait HandlesSubmissions
{
    /**
     * Save an admin reply on the submission and email it to the submitter.
     *
     * @param  array{reply_message: string, sender_name?: ?string, status?: ?string}  $data
     */
    protected function sendReply(Model $submission, array $data, string $subject): RedirectResponse
    {
        $attributes = [
            'reply_message' => $data['reply_message'],
            'replied_at' => now(),
        ];

        if (($data['status'] ?? null) !== null) {
            $attributes['status'] = $data['status'];
        }

        $submission->update($attributes);

        try {
            Mail::to($submission->email)->queue(new AdminReplyNotification(
                $submission->name,
                $data['reply_message'],
                $subject,
                $data['sender_name'] ?? 'The RUBIKNOWS Team',
            ));
        } catch (\Exception $e) {
            Log::error('Mail Error (Reply): '.$e->getMessage());

            return back()->with('error', 'Reply saved, but email could not be sent.');
        }

        return back()->with('success', 'Reply sent successfully.');
    }

    /**
     * Download one of the files sent with a submission, under its original name.
     */
    protected function downloadSubmissionFile(Model $submission, int $index)
    {
        $file = $submission->attachmentList()[$index] ?? null;
        abort_unless($file && $file['disk'], 404);

        return \Illuminate\Support\Facades\Storage::disk($file['disk'])->download($file['path'], $file['name']);
    }

    /**
     * Delete the submissions selected in an index table.
     *
     * @param  class-string<Model>  $model
     */
    protected function bulkDelete(Request $request, string $model, string $indexRoute, string $noun): RedirectResponse
    {
        $ids = $request->input('ids', []);

        if (empty($ids)) {
            return redirect()->route($indexRoute)->with('error', "No {$noun} selected.");
        }

        $model::whereIn('id', $ids)->get()->each(function (Model $submission): void {
            if (method_exists($submission, 'deleteAttachments')) {
                $submission->deleteAttachments();
            }
        });
        $model::whereIn('id', $ids)->delete();

        // Query-builder deletes skip model events, so clear the badge counts here.
        PublicContentCache::forgetAdminNotificationCounts();

        return redirect()->route($indexRoute)->with('success', "Selected {$noun} deleted successfully.");
    }
}
