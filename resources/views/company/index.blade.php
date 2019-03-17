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
                                <?php
                                    if($info->type == 'text')
                                        $icon = 'fa-align-left';
                                    if($info->type == 'email')
                                        $icon = 'fa-envelope';
                                    if(isset($info->number) and $info->number)
                                        $icon = 'fa-sort-numeric-down';
                                    if(isset($info->phone) and $info->phone)
                                        $icon = 'fa-mobile-alt';
                                    if(isset($info->address) and $info->address)
                                        $icon = 'fa-map-marker-alt';
                                    if($info->name == 'name')
                                        $icon = 'fa-signature';
                                    if(isset($info->start_point) and $info->start_point)
                                        $icon = 'fa-hand-point-right';
                                    if(isset($info->end_point) and $info->end_point)
                                        $icon = 'fa-hand-point-left';
                                    if(isset($info->cf) and $info->cf)
                                        $icon = 'fa-vote-yea';
                                    if(isset($info->city) and $info->city)
                                        $icon = 'fa-city';
                                    if(isset($info->country) and $info->country)
                                        $icon = 'fa-globe-europe';
                                    if(isset($info->vat) and $info->vat)
                                        $icon = 'fa-list-ol';
                                    if(isset($info->weight_cost) and $info->weight_cost)
                                        $icon = 'fa-weight';
                                    if(isset($info->weight) and $info->weight)
                                        $icon = 'fa-weight-hanging';
                                    if(isset($info->bank) and $info->bank)
                                        $icon = 'fa-university';
                                    if(isset($info->swift) and $info->swift)
                                        $icon = 'fa-money-check';
                                ?>
                                <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="fa {{ $icon }}"></i>
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