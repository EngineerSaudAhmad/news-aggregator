<x-mail::message>
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# @lang('Hello!')
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    $color = match ($level) {
        'success', 'error' => $level,
        default => 'primary',
    };

    // Parse the URL to extract its components
    $parsed_url = parse_url($actionUrl);

    // Extract the query string
    $query_string = $parsed_url['query'] ?? '';

    // Parse the query string into an associative array
    parse_str($query_string, $query_params);

    // Check if the 'token' parameter exists
    if (isset($query_params['token'])) {
        $token = $query_params['token'];
    } else {
        $token = null; // Or handle the case where the token is not found
    }
?>
        Token: {{ $token }}
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
    {{ str_replace('link', 'token', $line) }}
@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
    {{ $salutation }}
@else
    @lang('Regards'),<br>
    {{ config('app.name') }}
@endif
</x-mail::message>
