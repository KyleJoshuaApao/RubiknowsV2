<x-mail::message>
<div style="text-align: center; padding: 10px 0 25px 0; border-bottom: 2px solid #f3f4f6; margin-bottom: 25px;">
    <img src="https://i.imgur.com/DKn4Sb2.png" alt="Rubiknows Logo" style="height: 120px; width: auto; display: block; border: none; margin: 0 auto 15px auto; max-width: 100%;">
<div style="font-size: 36px; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; letter-spacing: -1px; text-transform: uppercase; line-height: 1.2; word-break: keep-all; white-space: nowrap; margin-top: 15px;">
<span style="font-weight: 300; color: #000000;">RUBI</span><span style="font-weight: 900; color: #E07B2A;">KNOWS</span>
</div>
</div>

# New Quotation Request

A potential client has requested a quotation from the **Rubiknows** website. Here are the project details:

<x-mail::table>
| Client Information | Details | Project Requirements | Details |
| :--- | :--- | :--- | :--- |
| **Name** | {{ $quotation->name }} | **Service Needed** | {{ $quotation->service_needed }} |
| **Email** | [{{ $quotation->email }}](mailto:{{ $quotation->email }}) | **Project Location** | {{ $quotation->project_location }} |
| **Company** | {{ $quotation->company ?: 'N/A' }} | **Estimated Budget** | {{ $quotation->budget ?: 'N/A' }} |
| **Phone** | {{ $quotation->phone ?: 'N/A' }} | **Project Timeline** | {{ $quotation->timeline ?: 'N/A' }} |
</x-mail::table>

### Project Description

<x-mail::panel>
{{ $quotation->description }}
</x-mail::panel>

@if($quotation->attachment_path)
> **Note:** The client has uploaded an attachment. Please view it in the Admin Dashboard.
@endif

<x-mail::button :url="url('/admin/quotations/' . $quotation->id)">
Open Request Details
</x-mail::button>

</x-mail::message>
