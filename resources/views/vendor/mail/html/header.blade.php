@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
    @if (trim($slot) === config('app.name'))
        <img src="https://res.cloudinary.com/dkr0rrd6k/image/upload/v1760839659/logo_branco_sirus_wbd4xh.png" alt="{{ config('app.name') }}" style="width:120px;">
    @else
{!! $slot !!}
@endif
</a>
</td>
</tr>
