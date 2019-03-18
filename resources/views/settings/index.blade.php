@extends('layout')
@section('content')
    <div class="row">
        <div class="col-md-6">
            <form class="form-horizontal" action="{{ route('settings') }}" method="post" enctype="multipart/form-data">
                <section class="panel">
                    <header class="panel-heading">
                        <h2 class="panel-title">{{ $title }}</h2>
                        <p class="panel-subtitle">
                            {{ $description }}
                        </p>
                    </header>
                    <div class="panel-body">
                    @foreach($data as $setting)
                        <div class="form-group">
                            <label class="col-sm-4 control-label">{{ $setting->description }}</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-align-left"></i>
                                </span>
                                    <input placeholder="{{ $setting->description }}" type="text" name="setting[{{ $setting->id }}][value]" value="{{ $setting->value }}" class="form-control">
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </div>
                    <footer class="panel-footer">
                        <button class="btn btn-primary" type="submit">Submit </button>
                    </footer>
                </section>
            </form>
        </div>
    </div>
@endsection