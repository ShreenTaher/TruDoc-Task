@component('mail::message')

    Welcome in Tru Doc Family. <br>

    Accepted Records Count is: {{$success}}

    Rejected Records Count is: {{$failure}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
