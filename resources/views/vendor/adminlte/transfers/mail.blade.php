@component('mail::message')
    Transfer Details

    Hello {{$name}}, {{$userCompany}}  {{-- use double space for line break --}}

    Please find the attachment for transfer order ({{$reference_number}}) details.

    Best regards,
    {{$company}}
@endcomponent
