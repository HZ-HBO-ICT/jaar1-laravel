@if (count($breadcrumbs))

    <ol class="breadcrumb">
        @foreach ($breadcrumbs as $breadcrumb)

            @if ($breadcrumb->url && !$loop->last)
                <li class="breadcrumb-item">
                    <a href="{{ $breadcrumb->url }}">
                        @if (isset($breadcrumb->icon))
                            <i class="fa fa-{{ $breadcrumb->icon }}"></i>
                        @endif
                        @lang($breadcrumb->title)
                    </a>
                </li>
            @else
                <li class="breadcrumb-item active">
                    @if (isset($breadcrumb->icon))
                        <i class="fa fa-{{ $breadcrumb->icon }}"></i>
                    @endif
                    @lang($breadcrumb->title)
                </li>
            @endif

        @endforeach
    </ol>

@endif