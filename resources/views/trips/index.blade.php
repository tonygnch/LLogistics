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
                                <th>Client</th>
                                <th>Driver</th>
                                <th>Truck</th>
                                <th>Trailer</th>
                                <th>Description</th>
                                <th>Departed</th>
                                <th>Arrived</th>
                                <th>Start Point</th>
                                <th>End Point</th>
                                <th>Distance</th>
                                <th>Invoiced</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $d)
                                <tr>
                                    <td>@if(!empty($d->client())) {{ $d->client()->name }} @endif</td>
                                    <td>@if(!empty($d->driver())) {{ $d->driver()->name }} {{$d->driver()->surname}} @endif</td>
                                    <td>@if(!empty($d->truck())) {{ $d->truck()->plate }} - {{ $d->truck()->make }} @endif</td>
                                    <td>@if(!empty($d->trailer())) {{ $d->trailer()->plate }} - {{ $d->trailer()->make }} @endif</td>
                                    <td>{{ $d->description }}</td>
                                    <td>{{ date('d M Y', strtotime($d->departed)) }}</td>
                                    <td>{{ date('d M Y', strtotime($d->arrived)) }}</td>
                                    <td>{{ $d->start_point }}</td>
                                    <td>{{ $d->end_point }}</td>
                                    <td>{{ $d->distance }}</td>
                                    <td class="text-center"><i class="fa @if($d->invoiced) fa-check @else fa-times @endif"></i></td>
                                    <td class="actions">
                                        <a href="{{ route('modifyTrip', $d->id) }}"><i class="fa fa-pencil-alt fa-2x" style="color: orange;"></i></a>
                                        <a href="{{ route('deleteTrip', $d->id) }}" class="delete-row"><i class="fa fa-trash-alt fa-2x" style="color: #ed180e;"></i></a>
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