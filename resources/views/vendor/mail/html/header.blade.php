@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
    @if (trim($slot) === config('app.name'))
        <img src="https://i.postimg.cc/pVFLctgK/logo-Sirus.png" alt="{{ config('app.name') }}" style="width:120px;">
    @else
{!! $slot !!}
@endif
</a>
</td>
</tr>
