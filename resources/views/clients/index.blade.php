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
                                <th>Email</th>
                                @if($d->phone)<th>Phone</th>@endif
                                <th>Address</th>
                                <th>CF</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $d)
                                <tr>
                                    <td>{{ $d->name }}</td>
                                    <td>{{ $d->email }}</td>
                                    @if($d->phone)<td>{{ $d->phone }}</td>@endif
                                    <td>{{ $d->address }} {{ $d->cf }} {{ $d->city }} {{ $d->country }}</td>
                                    <td>{{ $d->vat }}</td>
                                    <td class="actions">
                                        <a href="{{ route('modifyClient', $d->id) }}"><i class="fa fa-pencil-alt fa-2x" style="color: orange;"></i></a>
                                        <a href="{{ route('deleteClient', $d->id) }}" class="delete-row"><i class="fa fa-trash-alt fa-2x" style="color: #ed180e;"></i></a>
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