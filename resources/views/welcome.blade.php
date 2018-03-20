{{-- resources/views/admin/dashboard.blade.php --}}

@extends('adminlte::page')

@section('title', __('messages.home'))

@section('breadcrumbs')
    {{ Breadcrumbs::render('home') }}
@stop

@section('content')
    <p>Welcome to this beautiful admin panel.</p>
@stop

@push('css')

@push('js')