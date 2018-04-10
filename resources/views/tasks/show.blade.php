{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', __('messages.task_mgmt'))

@section('breadcrumbs')
    {{ Breadcrumbs::render('task', $task) }}
@stop

@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">
                {{ $task->title }}
                @for($i=1; $i<=$task->rating; $i++)
                    <i class="fa fa-star text-yellow"></i>
                @endfor
            </h3>
            <div class="btn-group pull-right">
                <a type="button"
                   href="{{ $task->parent ? route('tasks.show', ['task' => $task->parent]) : route('tasks.index') }}"
                   class="btn btn-default">
                    <i class="fa fa-arrow-circle-up"></i>&nbsp @lang('messages.back')
                </a>
                <a type="button" class="btn btn-warning"
                   href="{{ route('tasks.edit', $task) }}"><i class="fa fa-pencil"></i>&nbsp @lang('messages.edit')</a>
                <button type="button" class="btn btn-danger"
                        data-toggle="modal" data-target="#modal-delete-task">
                    <i class="fa fa-trash-o"></i>&nbsp @lang('messages.delete')
                </button>
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
                <span>
                @switch($task->state)
                        @case(0)
                        <span class="label bg-gray">@lang('messages.task.state.todo')</span>
                        @break
                        @case(1)
                        <span class="label bg-primary">@lang('messages.task.state.doing')</span>
                        @break
                        @case(2)
                        <span class="label bg-red">@lang('messages.task.state.onhold')</span>
                        @break
                        @case(3)
                        <span class="label bg-green">@lang('messages.task.state.done')</span>
                        @break
                    @endswitch
                </span>
            <label for="progress">@lang('messages.task.progress')&nbsp{{ $task->hours_actual }}/{{ $task->hours_planned }}</label>
            <div class="progress progress-xs">
                <div class="progress-bar progress-bar-primary" style="width: {{ $task->progress }}%"></div>
            </div>
            <div class="row">
                <div class="col-md-{{ $task->has_children ? 6 : 10 }}">

                    <p>{!! $task->body !!}</p>
                </div>
                <div class="col-md-{{ $task->has_children ? 6 : 2 }}">
                    @if(!$task->has_children)
                        <a type="button" href="{{ route('tasks.create_child', ['task' => $task]) }}"
                           class="btn btn-primary pull-right"><i class="fa fa-plus"></i>&nbsp @lang('messages.insert') deeltaak
                        </a>
                    @else
                    <h3>Deeltaken
                        <a type="button" href="{{ route('tasks.create_child', ['task' => $task]) }}"
                           class="btn btn-primary pull-right"><i class="fa fa-plus"></i>&nbsp @lang('messages.insert') deeltaak
                        </a>
                    </h3>
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th>@lang('messages.task.title')</th>
                            <th>@lang('messages.task.progress')</th>
                        </tr>
                        @foreach($task->children()->get()->sortByDesc('state') as $subtask)
                            <tr>
                                <td><a href="{{ route('tasks.show', ['task' => $subtask]) }}">{{ $subtask->title }}</a>
                                </td>
                                <td>
                                    @switch($subtask->state)
                                        @case(0)
                                        <span class="label bg-gray">@lang('messages.task.state.todo')</span>
                                        @break
                                        @case(1)
                                        <div class="progress progress-xs">
                                            <div class="progress-bar progress-bar-primary" style="width: {{ $subtask->progress }}%"></div>
                                        </div>
                                        {{ $subtask->hours_actual }}/{{ $subtask->hours_planned }}
                                        @break
                                        @case(2)
                                        <span class="label bg-red">@lang('messages.task.state.onhold')</span>
                                        @break
                                        @case(3)
                                        <span class="label bg-green">@lang('messages.task.state.done')</span>
                                        @break
                                    @endswitch
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="modal modal-danger fade" id="modal-delete-subtask">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span></button>
                                    <h4 class="modal-title"><i
                                                class="fa fa-trash-o"></i>&nbsp @lang('messages.tasks_delete')</h4>
                                </div>
                                {{ Form::open([ 'route' => ['tasks.destroy', 0 ], 'method' => 'DELETE']) }}
                                <div class="modal-body">
                                    <p>One fine body…</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline pull-left"
                                            data-dismiss="modal">@lang('messages.cancel')</button>
                                    <button type="submit" class="btn btn-outline">@lang('messages.delete')</button>
                                </div>
                                {{ Form::close() }}
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- /.box-body -->
    </div>
    <div class="modal modal-danger fade" id="modal-delete-task">
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
                    <button type="button" class="btn btn-outline pull-left"
                            data-dismiss="modal">@lang('messages.cancel')</button>
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