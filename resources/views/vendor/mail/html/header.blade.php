@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
    @if (trim($slot) === 'SIRUS')
        <img src="https://i.postimg.cc/C5XKrJRm/logo-Sirus.png" alt="Laravel Logo" style="width:120px;">
    @else
{!! $slot !!}
@endif
</a>
</td>
</tr>
