<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body style="font-family: Arial;">

<h2>Application Status Update</h2>

<p>Hello {{ $application->candidate->full_name }},</p>

<p>
Your application for
<strong>{{ $application->job->job_title }}</strong>
has been updated.
</p>

<p>
<strong>Current Status:</strong>
{{ ucfirst($application->status) }}
</p>

@if($application->status == 'interview')
<p>📅 Please check your dashboard for interview details.</p>
@endif

@if($application->status == 'offered')
<p>🎉 Congratulations! An offer letter has been issued.</p>
@endif

<p>
Thank you for using our platform.
</p>

</body>
</html>
