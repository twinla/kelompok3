@props(['title' => 'Belum ada apa pun di sini', 'description' => null, 'symbol' => '✦'])
<div {{ $attributes->class(['empty-state']) }}>
    <div class="empty-icon" aria-hidden="true">{{ $symbol }}</div>
    <h3>{{ $title }}</h3>
    @if($description)<p>{{ $description }}</p>@endif
    @if(isset($action))<div class="empty-state-action">{{ $action }}</div>@endif
</div>
