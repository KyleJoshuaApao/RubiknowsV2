@extends('errors.layout')

@section('code', '429')
@section('title', 'Too many requests')

@section('heading')
Please wait a moment.
@endsection

@section('message')
We received several requests from you in a short time. Wait a minute, then try again.
@endsection
