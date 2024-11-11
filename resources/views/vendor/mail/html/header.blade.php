@props(['url'])
<tr>
<td class="header">
<a href="{{ "https://www.debate.com.mx/img/2022/10/14/hasbulla.jpg" }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://www.debate.com.mx/img/2022/10/14/hasbulla.jpg" alt="Logotipo" style="max-width: 150px; height: auto; margin-bottom: 20px;">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>

