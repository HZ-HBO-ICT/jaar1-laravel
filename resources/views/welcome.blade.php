{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', __('messages.home'))

@section('breadcrumbs')
    {{ Breadcrumbs::render('home') }}
@stop

@section('content')
    <p>Welcome to this beautiful admin panel.</p>
    <p>You can find the source for his project on <a href="https://github.com/HZICT/jaar1-laravel"><i class="fa fa-github"></i>&nbsp Github</a> </p>
@stop

@push('css')

@push('js')