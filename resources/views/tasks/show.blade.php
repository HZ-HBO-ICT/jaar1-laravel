{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', __('messages.task_mgmt'))

@section('breadcrumbs')
    {{ Breadcrumbs::render('task', $task) }}
@stop

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">@lang('messages.tasks_show')</h3>
            <div class="btn-group pull-right">
                <a type="button" class="btn btn-warning"
                   href="{{ route('tasks.edit', $task) }}"><i class="fa fa-pencil"></i>&nbsp  @lang('messages.edit')</a>
                <button type="button" class="btn btn-danger"
                        data-toggle="modal" data-target="#modal-delete">
                    <i class="fa fa-trash-o"></i>&nbsp  @lang('messages.delete')
                </button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <h2>{{ $task->title }}</h2>
            <label for="progress">@lang('messages.task.progress')</label>
            <div class="progress progress-xs">
                <div class="progress-bar progress-bar-primary" style="width: {{ $task->progress }}%"></div>
            </div>
            <p>{!! $task->body !!}</p>
        </div>
        <!-- /.box-body -->
    </div>
    <div class="modal modal-danger fade" id="modal-delete">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title"><i class="fa fa-trash-o"></i>&nbsp @lang('messages.tasks_delete')</h4>
                </div>
                {{ Form::open([ 'route' => ['tasks.destroy', $task->id ], 'method' => 'DELETE']) }}
                <div class="modal-body">
                    ({{ $task->id }}) {{ $task->title }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">@lang('messages.cancel')</button>
                    <button type="submit" class="btn btn-outline">@lang('messages.delete')</button>
                </div>
                {{ Form::close() }}
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
@stop

@push('css')

@push('js')