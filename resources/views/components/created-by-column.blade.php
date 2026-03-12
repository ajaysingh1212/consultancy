<td>

@if($model->creator)

<strong>{{ $model->creator->name }}</strong><br>

<small>{{ $model->creator->email }}</small><br>

<span class="badge bg-info">
{{ $model->creator->getRoleNames()->implode(', ') }}
</span>

@else

<span class="text-muted">System</span>

@endif

</td>
