<td>

<strong>{{ $model->creator->name ?? '-' }}</strong><br>

{{ $model->creator->email ?? '-' }}<br>

<span class="badge bg-primary">

{{ $model->creator->getRoleNames()->implode(', ') }}

</span>

</td>
