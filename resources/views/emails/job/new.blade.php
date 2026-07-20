<x-mail::message>
<div style="text-align: center; padding: 10px 0 25px 0; border-bottom: 2px solid #f3f4f6; margin-bottom: 25px;">
    <img src="https://i.imgur.com/DKn4Sb2.png" alt="Rubiknows Logo" style="height: 120px; width: auto; display: block; border: none; margin: 0 auto 15px auto; max-width: 100%;">
<div style="font-size: 36px; font-weight: 900; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; letter-spacing: -1px; text-transform: uppercase; line-height: 1.2; word-break: keep-all; white-space: nowrap; margin-top: 15px;">
<span style="color: #000000;">RUBI</span><span style="color: #E07B2A;">KNOWS</span>
</div>
</div>

# Job Application Received

A new candidate has submitted an application for an open position through the Careers portal. Here are their details:

<x-mail::table>
| Application Details | Information | Application Details | Information |
| :--- | :--- | :--- | :--- |
| **Applying For** | **{{ $application->job->title ?? 'Open Application' }}** | **Applicant Name** | {{ $application->name }} |
| **Email Address** | [{{ $application->email }}](mailto:{{ $application->email }}) | **Phone Number** | {{ $application->phone ?: 'Not provided' }} |
</x-mail::table>

### Applicant's Cover Letter

<x-mail::panel>
{{ $application->cover_letter ?: 'No cover letter was provided with this application.' }}
</x-mail::panel>

> **Attachments:** The applicant's Resume and Portfolio (if provided) can be securely downloaded from the Admin Dashboard.

<x-mail::button :url="url('/admin/applications/' . $application->id)">
Review Application
</x-mail::button>

</x-mail::message>
