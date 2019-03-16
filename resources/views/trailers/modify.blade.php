@extends('layout')
@section('content')
    @include('partials.modify')
@endsection

{{--<div class="panel-body">--}}
{{--@foreach ($data  as $d)--}}
{{--@if(!in_array($d, ['deleted']))--}}
{{--<div class="form-group">--}}
{{--<label class="col-sm-4 control-label">{{ ucfirst($d) }}: </label>--}}
{{--<div class="col-sm-8">--}}
{{--<input placeholder="{{ ucfirst($d) }}" type="text" name="{{ $d }}" class="form-control">--}}
{{--</div>--}}
{{--</div>--}}
{{--@endif--}}
{{--@endforeach--}}
{{--</div>--}}