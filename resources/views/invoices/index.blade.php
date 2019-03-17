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
                                <th>Number</th>
                                <th>Date</th>
                                <th>Client</th>
                                <th>CMR</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $d)
                                <tr>
                                    <td>{{ $d->number }}</td>
                                    <td>{{ $d->date }}</td>
                                    <td>{{ $d->client()->name }}</td>
                                    <td>{{ $d->cmr }}</td>
                                    <td class="actions">
                                        <a href="{{ route('generateInvoicePdf', $d->id) }}"><i class="fas fa-file-invoice fa-2x" style="color: green;"></i></a>
                                        <a href="{{ route('modifyInvoice', $d->id) }}"><i class="fa fa-pencil-alt fa-2x" style="color: orange;"></i></a>
                                        <a href="{{ route('deleteInvoice', $d->id) }}" class="delete-row"><i class="fa fa-trash-alt fa-2x" style="color: #ed180e;"></i></a>
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