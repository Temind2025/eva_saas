@props(["small"=>""])
<button onclick="window.history.back();" class="btn btn-secondary btn-icon {{($small=='true')? 'btn-sm' : ''}}" data-bs-toggle="tooltip" title="{{__('messages.return_back')}}"><i class="fas fa-reply"></i>&nbsp;{{ $slot }}</button>
