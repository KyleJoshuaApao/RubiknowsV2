<x-mail::message>
<div style="text-align: center; padding: 10px 0 25px 0; border-bottom: 2px solid #f3f4f6; margin-bottom: 25px;">
    <img src="https://i.imgur.com/DKn4Sb2.png" alt="Rubiknows Logo" style="height: 120px; width: auto; display: block; border: none; margin: 0 auto 15px auto; max-width: 100%;">
<div style="font-size: 36px; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; letter-spacing: -1px; text-transform: uppercase; line-height: 1.2; word-break: keep-all; white-space: nowrap; margin-top: 15px;">
<span style="font-weight: 300; color: #000000;">RUBI</span><span style="font-weight: 900; color: #E07B2A;">KNOWS</span>
</div>
</div>

# You Have a New Inquiry!

A new general inquiry was just submitted from the **Rubiknows** public website. Here are the contact details and message:

<x-mail::table>
| Contact Info | Details | Contact Info | Details |
| :--- | :--- | :--- | :--- |
| **Name** | {{ $messageData->name }} | **Company** | {{ $messageData->company ?: 'N/A' }} |
| **Email** | [{{ $messageData->email }}](mailto:{{ $messageData->email }}) | **Phone** | {{ $messageData->phone ?: 'N/A' }} |
</x-mail::table>

---

### Subject: {{ $messageData->subject }}

<x-mail::panel>
{{ $messageData->message }}
</x-mail::panel>

<x-mail::button :url="url('/admin/messages/' . $messageData->id)">
Review in Admin Portal
</x-mail::button>

</x-mail::message>
