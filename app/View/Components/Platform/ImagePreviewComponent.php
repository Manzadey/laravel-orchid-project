<?php

declare(strict_types=1);

namespace App\View\Components\Platform;

use App\Models\Media;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ImagePreviewComponent extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(readonly public Media $media)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render() : View
    {
        return view('components.platform.image-preview-component');
    }
}
