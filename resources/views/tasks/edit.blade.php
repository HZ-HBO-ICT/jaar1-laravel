{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', __('messages.task_mgmt'))

@section('breadcrumbs')
    {{ Breadcrumbs::render('tasks.edit', $task) }}
@stop

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">@lang('messages.tasks_edit')</h3>
        </div>
        <form action="{{ route("tasks.update", ['task' => $task]) }}" method="POST" accept-charset="UTF-8">
            {{ method_field('PATCH') }}
            {{ csrf_field() }}
            <div class="box-body">
                <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                    <label for="title" class="control-label">@lang('messages.task.title')</label>
                    <input type="" id="title" name="title" class="form-control" value="{{ $task->title }}"
                           placeholder="Enter text">
                    @if ($errors->has('title'))
                        <span class="help-block">
                        <strong>{{ $errors->first('title') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('progress') ? 'has-error' : '' }}">
                    <label for="progress" class="control-label">@lang('messages.task.progress')</label>
                    <input type="text" id="progress" name="progress" class="form-control" value="{{ $task->progress }}"
                           placeholder="0 ... 100">
                    @if ($errors->has('progress'))
                        <span class="help-block">
                        <strong>{{ $errors->first('progress') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('body') ? 'has-error' : '' }}">
                    <label for="body" class="control-label">@lang('messages.task.body')</label>
                    <textarea class="textarea" id="body" name="body"
                              style="width: 100%; height: 200px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;"
                              placeholder="Place some text here">{{ $task->body }}</textarea>
                    @if ($errors->has('body'))
                        <span class="help-block">
                                <strong>{{ $errors->first('body') }}</strong>
                            </span>
                    @endif
                </div>

            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary">@lang('messages.submit')</button>
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
