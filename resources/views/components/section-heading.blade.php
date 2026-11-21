@props(['eyebrow' => null, 'title', 'description' => null])
<header {{ $attributes->class(['tp-section-heading']) }}>
    <div>
        @if($eyebrow)<div class="tp-eyebrow">{{ $eyebrow }}</div>@endif
        <h2>{{ $title }}</h2>
        @if($description)<p>{{ $description }}</p>@endif
    </div>
    @if(isset($action))<div class="tp-section-heading-action">{{ $action }}</div>@endif
</header>
