{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')

@section('title', __('messages.task_mgmt'))

@section('breadcrumbs')
    {{ Breadcrumbs::render('tasks') }}
@stop


@section('content')
    <div class="box">
        <div class="box-header with-border">
            <h3 class="box-title">@lang('messages.tasks_index')</h3>
            <a type="button" href="{{ route('tasks.create') }}" class="btn btn-primary pull-right"><i class="fa fa-plus"></i>&nbsp @lang('messages.insert')</a>

        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table class="table table-bordered">
                <tbody><tr>
                    <th style="width: 10px">#</th>
                    <th>@lang('messages.task.title')</th>
                    <th>@lang('messages.task.rating')</th>
                    <th>@lang('messages.task.hours_planned')</th>
                    <th>@lang('messages.task.hours_remaining')</th>
                    <th>@lang('messages.task.progress')</th>
                    <th><span class="pull-right">@lang('messages.task.options')</span></th>
                </tr>
                @foreach($tasks as $task)
                    <tr>
                        <td>{{ $task->id }}</td>
                        <td><a href="{{ route('tasks.show', ['task' => $task]) }}">{{ $task->title }}</a></td>
                        <td>
                            @for($i=1; $i<=$task->rating; $i++)
                                <i class="fa fa-star text-yellow"></i>
                            @endfor
                        </td>
                        <td>{{ $task->hours_planned }}</td>
                        <td>{{ $task->hours_remaining }}</td>
                        <td>
                            @switch($task->state)
                                @case(0)
                                    <span class="label bg-gray">@lang('messages.task.state.todo')</span>
                                @break
                                @case(1)
                                    <div class="progress">
                                        <div class="progress-bar progress-bar-striped progress-bar-primary" style="width: {{ $task->progress }}%">
                                            {{ round($task->progress) }}%
                                        </div>
                                    </div>
                                @break
                                @case(2)
                                    <span class="label bg-red text-uppercase">@lang('messages.task.state.onhold')</span>
                                @break
                                @case(3)
                                    <span class="label bg-green">@lang('messages.task.state.done')</span>
                                @break
                            @endswitch
                        </td>
                        <td>
                            <div class="btn-group pull-right">
                                <a type="button" class="btn btn-sm btn-warning"
                                   href="{{ route('tasks.edit', $task) }}"><i class="fa fa-pencil"></i>&nbsp  @lang('messages.edit')</a>
                                <button type="button" class="btn btn-sm btn-danger"
                                        data-toggle="modal" data-target="#modal-delete"
                                        data-id="{{ $task->id }}" data-title="{{ $task->title }}">
                                    <i class="fa fa-trash-o"></i>&nbsp  @lang('messages.delete')
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="modal modal-danger fade" id="modal-delete">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span></button>
                            <h4 class="modal-title"><i class="fa fa-trash-o"></i>&nbsp @lang('messages.tasks_delete')</h4>
                        </div>
                        {{ Form::open([ 'route' => ['tasks.destroy', 0 ], 'method' => 'DELETE']) }}
                        <div class="modal-body">
                            <p>One fine body…</p>
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
            </div>
            <!-- /.box-body -->
        </div>
    </div>
@stop

@push('css')

@push('js')
    <script type="application/javascript">
        $('#modal-delete').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) // Button that triggered the modal

            // Extract info from data-* attributes
            var id = button.data('id')
            var title = button.data('title')

            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('form').attr('action', '{{ route('tasks.index') }}/' + id); // Update URL
            modal.find('.modal-body p').html('('+id+') '+title)                                 // Update body
        })
    </script>
@endpush