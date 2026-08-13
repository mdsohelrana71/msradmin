<div class="page-header">
    <ul class="breadcrumbs">
        <li class="nav-home">
            <a href="{{ route('admin.dashboard') }}">
                <i class="icon-home"></i>
            </a>
        </li>

        @foreach ($items as $item)
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>

            <li class="nav-item">
                @if (!empty($item['url']))
                    <a href="{{ $item['url'] }}">
                        {{ $item['label'] }}
                    </a>
                @else
                    <span>{{ $item['label'] }}</span>
                @endif
            </li>
        @endforeach
    </ul>

    @if (!empty($action))
        <a
            href="{{ $action['url'] }}"
            class="btn btn-primary btn-round ms-auto"
        >
            @if (!empty($action['icon']))
                <i class="{{ $action['icon'] }} me-1"></i>
            @endif

            {{ $action['label'] }}
        </a>
    @endif
</div>