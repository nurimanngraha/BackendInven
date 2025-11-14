@props(['url'])
<tr>
  <td class="header" align="center">
    @if (trim($slot) === 'Laravel')
        @php
            $logoUrl = 'https://i.ibb.co.com/k221trdy/sanditel-logo.png';                        
        @endphp
        <img src="{{ $logoUrl }}" alt="Sanditel Logo" style="height:60px;">
    @else
        {{ $slot }}
    @endif
  </td>
</tr>
