@component('mail::message')
# Service {{ $service }} deployed

Your service deploy succeed!
@if($commands)
> Commands
```bash
@foreach($commands as $line)
* {{$line}}
@endforeach
```
@endif

From, <br>
Web hook by Laravel @ {{ date('Y-m-d H:i:s') }}
@endcomponent
