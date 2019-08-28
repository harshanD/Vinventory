@component('mail::message')
    Sale Details

    Hello {{$name}}, {{$userCompany}}  {{-- use double space for line break --}}

    Please find the attachment for your order ({{$reference_number}}) details.

    Best regards,
    {{$company}}
@endcomponent
