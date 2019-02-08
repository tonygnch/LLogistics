@extends('layout')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <section class="panel">
                <header class="panel-heading">
                    <div class="panel-actions">
                        <a href="#" class="fa fa-caret-down"></a>
                        <a href="#" class="fa fa-times"></a>
                    </div>

                    <h2 class="panel-title">Actions</h2>
                </header>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table mb-none">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Plate</th>
                                <th>Make and model</th>
                                <th>Trailer</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $d)
                                <tr>
                                    <td>{{ $d->id }}</td>
                                    <td>{{ $d->plate }}</td>
                                    <td>{{ $d->make }} {{ $d->model }}</td>
                                    <td>@if($d->trailer) {{ $d->trailer }} @else - @endif</td>
                                    <td class="actions">
                                        <a href="{{ route('modifyTruck', $d->id) }}"><i class="fa fa-pencil"></i></a>
                                        <a href="{{ route('deleteTruck', $d->id) }}" class="delete-row"><i class="fa fa-trash-o"></i></a>
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