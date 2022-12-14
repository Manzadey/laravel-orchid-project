@php
    /* @var \App\Models\Media $media */
@endphp

@if($media->hasGeneratedConversion('platform'))
    <img class="img-fluid rounded lozad" src="{{ url('images/no_image.svg') }}" data-src="{{ $media->getUrl('platform') }}" alt="{{ $media->name }}">
@else
    <img class="img-fluid rounded" src="{{ url('images/no_image.svg') }}" alt="{{ $media->name }}">
@endif
