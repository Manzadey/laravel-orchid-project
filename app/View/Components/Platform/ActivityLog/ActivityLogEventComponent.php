<?php

namespace App\View\Components\Platform\ActivityLog;

use App\Models\ActivityLog;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ActivityLogEventComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(readonly public ActivityLog $activityLog)
    {
        //
    }

    public function color() : string
    {
        return match ($this->activityLog->event) {
            'created' => 'success',
            'deleted' => 'danger',
            default => 'primary',
        };
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render() : View
    {
        return view('components.platform.activity-log.activity-log-event-component');
    }
}
