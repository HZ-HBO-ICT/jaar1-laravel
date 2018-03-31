{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', __('messages.task_mgmt'))

@section('breadcrumbs')
    {{ Breadcrumbs::render('tasks.create') }}
@stop

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">@lang('messages.tasks_create')</h3>
        </div>
        @if($task)
            <form action="{{ route("tasks.store_child", ['task' => $task]) }}" method="POST" accept-charset="UTF-8">
        @else
            <form action="{{ route("tasks.store") }}" method="POST" accept-charset="UTF-8">
        @endif
            {{ csrf_field() }}
            <div class="box-body">
                <div class="form-group">
                    <label for="title">@lang('messages.task.title')</label>
                    <input type="text" class="form-control" name="title" id="title" placeholder="Enter text">
                </div>
                <div class="form-group">
                    <label for="hours_planned">@lang('messages.task.hours_planned')</label>
                    <input type="text" class="form-control" name="hours_planned" id="hours_planned" placeholder="Enter a number">
                </div>
                <div class="form-group">
                    <label for="body" class="control-label">@lang('messages.task.body')</label>
                    <textarea class="textarea" id="body" name="body"
                              style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"
                              placeholder="Place some text here"></textarea>
                </div>
            </div>
            <div class="box-footer">
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">@lang('messages.submit')</button>
                    <a href="{{ url()->previous() }}" class="btn btn-default">@lang('messages.cancel')</a>
                </div>
            </div>
        </form>
    </div>
@stop

@push('css')
    <link rel="stylesheet" href="{!! asset('css/bootstrap3-wysihtml5.min.css') !!}"/>
@endpush

@push('js')
    <script src="{!! asset('js/bootstrap3-wysihtml5.all.min.js') !!}"></script>
    <script>
        $(function () {
            //bootstrap WYSIHTML5 - text editor
            $('.textarea').wysihtml5()
        })
    </script>
@endpush
