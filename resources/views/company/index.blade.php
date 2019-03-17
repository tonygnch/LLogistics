@extends('layout')
@section('content')
    <div class="row">
        <div class="col-md-6">
            <form class="form-horizontal" action="{{ route('company') }}" method="post" enctype="multipart/form-data">
                <section class="panel">
                    <header class="panel-heading">
                        <h2 class="panel-title">{{ $title }}</h2>
                        <p class="panel-subtitle">
                            {{ $description }}
                        </p>
                    </header>
                    <div class="panel-body">
                    @foreach($inputs as $label => $info)
                        <div class="form-group">
                            <label class="col-sm-4 control-label">{{ $label }}</label>
                            <div class="col-sm-8">
                                <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa fa-align-left"></i>
                                </span>
                                    <input placeholder="{{ $label }}" type="text" name="company[{{ $info->name }}]" value="{{ $info->value }}" class="form-control" @if($info->required) required @endif>
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