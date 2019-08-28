@component('mail::message')
    Purchase Details

    Hello {{$name}}, {{$userCompany}}  {{-- use double space for line break --}}

    Please find the attachment for our purchase order ({{$reference_number}}) details.

    Best regards,
    {{$company}}
@endcomponent
