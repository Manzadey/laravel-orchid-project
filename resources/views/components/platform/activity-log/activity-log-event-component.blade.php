@php
    /* @var \App\Models\ActivityLog $activityLog */
@endphp

<div class="text-{{ $color }}">
    {{ $activityLog->event }}
</div>
