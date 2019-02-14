@extends('layout')
@section('content')
    <div class="row">
        <div class="col-md-6">
            <form class="form-horizontal" action="{{ route('modifyTrailer', $data->id) }}" method="post" enctype="multipart/form-data">
                <section class="panel">
                    <header class="panel-heading">
                        <h2 class="panel-title">{{ $title }}</h2>
                        <p class="panel-subtitle">
                            {{ $description }}
                        </p>
                    </header>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Plate: </label>
                            <div class="col-sm-8">
                                <input placeholder="Plate" type="text" name="plate" class="form-control" value="{{ $data->plate }}" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Make: </label>
                            <div class="col-sm-8">
                                <select class="form-control" data-plugin-multiselect name="make" required>
                                    @foreach($makes as $make)
                                        <option value="{{ $make }}" @if($data->make == $make) selected @endif >{{ $make }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Model: </label>
                            <div class="col-sm-8">
                                <input placeholder="Model" type="text" name="model" class="form-control" value="{{ $data->model }}" required>
                            </div>
                        </div>
                    </div>
                    <footer class="panel-footer center">
                        <button class="btn btn-primary" type="submit">Submit </button>
                    </footer>
                </section>
            </form>
        </div>
    </div>

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