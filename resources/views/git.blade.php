@component('mail::message')
# Service {{ $service }} deployed

Your service deploy succeed!
@if($commands)
#### Commands:
```bash
@foreach($commands as $key => $line)
$ {{$line}}
@endforeach
```
@endif

@if($outputs)
#### Outputs:
```
@foreach($outputs as $key => $line)
{{$line}}
@endforeach
```
@endif
From {{ config('app.name') }}, <br>
Web hook by Laravel @ {{ date('Y-m-d H:i:s') }}
@endcomponent
