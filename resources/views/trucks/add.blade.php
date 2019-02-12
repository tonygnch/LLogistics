@extends('layout')
@section('content')
    <div class="row">
        <div class="col-md-6">
            <form class="form-horizontal" action="{{ route('addTruck') }}" method="post" enctype="multipart/form-data">
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
                                <input placeholder="Plate" type="text" name="plate" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Make: </label>
                            <div class="col-sm-8">
                                <select class="form-control" data-plugin-multiselect name="make" required>
                                    @foreach($makes as $make)
                                        <option value="{{ $make }}" @if($loop->first) selected @endif >{{ $make }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Model: </label>
                            <div class="col-sm-8">
                                <input placeholder="Model" type="text" name="model" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Trailer: </label>
                            <div class="col-sm-8">
                                <select class="form-control" data-plugin-multiselect name="trailer">
                                    <option value="0">No Trailer</option>
                                    @foreach($trailers as $trailer)
                                        <option value="{{ $trailer->id  }}">{{ $trailer->plate }} - {{ $trailer->make }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <footer class="panel-footer">
                        <button class="btn btn-primary" type="submit">Submit </button>
                        <button type="reset" class="btn btn-default">Reset</button>
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