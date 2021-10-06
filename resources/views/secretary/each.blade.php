@foreach($events as $row)
<div class="toast show" @if($row->watch == 0) onclick="seen('{{ $row->id }}', this);" @endif>
    <div class="toast-header {{ $label[$type][$row->index] }} bg-gradient bg-opacity-75 text-white">
        <strong class="me-auto">{!! $row->title !!}</strong>
        <small>{{ $row->deadline }}</small>
        
        @if($row->watch == 0)
        <span class="p-2 bg-danger rounded-circle">
            <span class="visually-hidden">alert</span>
        </span>
        @endif
    </div>
    <div class="toast-body">{!! $row->content !!}</div>
</div>
@endforeach
