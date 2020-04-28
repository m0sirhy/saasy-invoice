@if (strlen($text) > 30)
{{ substr($text, 0, 30) }}...
@else
{{ $text }}
@endif
