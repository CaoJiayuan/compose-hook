@component('mail::message')
# Service {{ $service }} deployed

Your service deploy succeed!

@if($url)
    @component('mail::button', ['url' => $url])
        View
    @endcomponent
@endif

From, <br>
Web hook by Laravel @ {{ date('Y-m-d H:i:s') }}
@endcomponent
