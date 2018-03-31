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
            <input type="hidden" name="previous_url" value="{{ url()->previous() }}">
            <div class="box-body">
                <div class="form-group {{ $errors->has('title') ? 'has-error' : '' }}">
                    <label for="title" class="control-label">@lang('messages.task.title')</label>
                    <input type="text" id="title" name="title" class="form-control" value="{{ $task->title }}"
                           placeholder="Enter text">
                    @if ($errors->has('title'))
                        <span class="help-block">
                        <strong>{{ $errors->first('title') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="rating" class="control-label">@lang('messages.task.rating')</label>
                    <input type="hidden" id="rating" name="rating" value="{{ $task->rating }}">
                    <div class="form-group">
                        <span class="rating fa fa-star-o" id="star-0"></span>
                        @for($i=1; $i<=5; $i++)
                            <span class="rating fa fa-star {{ $i <= $task->rating ? "text-yellow" : "" }}" id="star-{{ $i }}"></span>
                        @endfor
                    </div>
                </div>
                @if( !$task->has_children )
                    <div class="form-group {{ $errors->has('hours_planned') ? 'has-error' : '' }}">
                        <label for="hours_planned" class="control-label">@lang('messages.task.hours_planned')</label>
                        <input type="text" id="hours_planned" name="hours_planned" class="form-control" value="{{ $task->hours_planned }}"
                               placeholder="Enter a number">
                        @if ($errors->has('hours_planned'))
                            <span class="help-block">
                                <strong>{{ $errors->first('hours_planned') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="state" class="control-label">@lang('messages.task.state')</label>
                        <div class="form-group">
                            <!--Checkbox butons-->
                            <div class="btn-group" data-toggle="buttons">
                                <label class="btn btn-default active form-check-label">
                                    <input name="state" value="0" {{ $task->state == 0 ? "checked" : "" }}
                                           class="form-check-input" type="radio" autocomplete="off"> @lang('messages.task.state.todo')
                                </label>
                                <label class="btn btn-primary form-check-label">
                                    <input name="state" value="1" {{ $task->state == 1 ? "checked" : "" }}
                                           class="form-check-input" type="radio" autocomplete="off"> @lang('messages.task.state.doing')
                                </label>
                                <label class="btn btn-danger form-check-label">
                                    <input name="state" value="2" {{ $task->state == 2 ? "checked" : "" }}
                                           class="form-check-input" type="radio" autocomplete="off"> @lang('messages.task.state.onhold')
                                </label>
                                <label class="btn btn-success form-check-label">
                                    <input name="state" value="3" {{ $task->state == 3 ? "checked" : "" }}
                                           class="form-check-input" type="radio" autocomplete="off"> @lang('messages.task.state.done')
                                </label>
                            </div>
                            <!--Checkbox butons-->
                        </div>
                    </div>
                    <div class="form-group {{ $errors->has('progress') ? 'has-error' : '' }}">
                        <label for="progress" class="control-label">@lang('messages.task.progress')</label>
                        <div class="form-group">
                            <input type="text" id="progress" name="progress"
                                   data-slider-id='ex1Slider' data-slider-min="0" data-slider-max="100" data-slider-step="1"
                                   data-slider-value="{{ $task->progress }}"/>
                            <span id="hours_remaining">@lang('messages.task.hours_remaining'): <span id="hours_remaining_value">{{ $task->hours_remaining }}</span></span>
                        </div>
                        @if ($errors->has('progress'))
                            <span class="help-block">
                            <strong>{{ $errors->first('progress') }}</strong>
                        </span>
                        @endif
                    </div>
                @endif
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
                <a href="{{ url()->previous() }}" class="btn btn-default">@lang('messages.cancel')</a>
            </div>
        </form>
    </div>
@stop

@push('css')
    <link rel="stylesheet" href="{!! asset('css/bootstrap3-wysihtml5.min.css') !!}"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/css/bootstrap-slider.min.css">
    <style>
        .rating {
            unicode-bidi: bidi-override;
            direction: rtl;
            font-size: 30px
        }

        .rating:hover {
            cursor: pointer
        }
    </style>
@endpush

@push('js')
    <script src="{!! asset('js/bootstrap3-wysihtml5.all.min.js') !!}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-slider/10.0.0/bootstrap-slider.min.js"></script>
    <script>
        $(function () {
            //bootstrap WYSIHTML5 - text editor
            $('.textarea').wysihtml5();
            $('#progress').slider({
                formatter: function(value) {
                    return 'Current value: ' + value;
                }
            });
            $('.rating').click(function(ev) {
                id = ev.target.id
                value = id.substr(5, id.length);
                $('input#rating').val(value);
                // Update which stars must be checked
                $('.rating').removeClass('text-yellow');
                for (i=1; i <= value;  i++) {
                    $('#star-' + i).addClass("text-yellow");
                }
            });
        })
    </script>
@endpush
