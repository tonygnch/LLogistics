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
                                <th>Name</th>
                                <th>Truck</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $d)
                                <tr>
                                    <td>{{ $d->name }} {{ $d->surname }}</td>
                                    <td>{{ $d->truck }}</td>
                                    <td class="actions">
                                        <a href="{{ route('modifyDriver', $d->id) }}"><i class="fa fa-pencil-alt fa-2x" style="color: orange;"></i></a>
                                        <a href="{{ route('deleteDriver', $d->id) }}" class="delete-row"><i class="fa fa-trash-alt fa-2x" style="color: #ed180e;"></i></a>
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