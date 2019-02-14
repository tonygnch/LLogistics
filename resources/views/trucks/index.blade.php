@extends('layout')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    <h2 class="panel-title">Actions</h2>
                </header>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table mb-none">
                            <thead>
                            <tr>
                                <th>Plate</th>
                                <th>Make and model</th>
                                <th>Trailer</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $d)
                                <tr>
                                    <td>{{ $d->plate }}</td>
                                    <td>{{ $d->make }} {{ $d->model }}</td>
                                    <td>@if($d->trailer) {{ $d->trailer()->plate }} - {{ $d->trailer()->make }} @else - @endif</td>
                                    <td class="actions">
                                        <a href="{{ route('modifyTruck', $d->id) }}"><i class="fa fa-pencil-alt fa-2x" style="color: orange;"></i></a>
                                        <a href="{{ route('deleteTruck', $d->id) }}" class="delete-row"><i class="fa fa-trash-alt fa-2x" style="color: #ed180e;"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection