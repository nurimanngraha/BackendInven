<x-mail::message>

{{-- 🌈 Gaya Modern & Halus --}}
<style>
    body {
        background-color: #f7fafc !important;
        font-family: 'Inter', Arial, sans-serif !important;
    }

    .mail-container {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        padding: 30px;
        margin: 20px auto;
        max-width: 600px;
        text-align: center;
    }

    .mail-title {
        font-size: 22px;
        font-weight: 600;
        color: #333333;
        margin-bottom: 10px;
    }

    .mail-text {
        color: #555555;
        font-size: 15px;
        line-height: 1.6;
    }

    .mail-footer {
        font-size: 12px;
        color: #888888;
        margin-top: 25px;
        text-align: center;
    }
</style>

<div class="mail-container">

{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
<h1 class="mail-title">@lang('Reset Password')</h1>
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
<p class="mail-text">{{ $line }}</p>
@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    $color = match ($level) {
        'success', 'error' => $level,
        default => 'primary',
    };
?>
<x-mail::button :url="$actionUrl" :color="$color" style="border-radius:8px; background-color:#0d87c6; color:#fff; font-weight:600; padding:12px 28px;">
{{ $actionText }}
</x-mail::button>
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
<p class="mail-text">{{ $line }}</p>
@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
<p class="mail-text">@lang('Regards'),<br>Sanditel Apps</p>
@endif

{{-- Subcopy --}}
@isset($actionText)
<x-slot:subcopy>
@lang(
    "Jika kamu mengalami kesulitan mengklik tombol \":actionText\", salin dan tempel URL di bawah ini\nke browser kamu:",
    [
        'actionText' => $actionText,
    ]
)
<span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
</x-slot:subcopy>
@endisset

<div class="mail-footer">
    &copy; {{ date('Y') }} Sanditel Apps. Semua hak dilindungi.
</div>
</div>

</x-mail::message>
