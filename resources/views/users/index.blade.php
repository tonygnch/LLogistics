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
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $d)
                                <tr>
                                    <td>{{ $d->first_name }} {{ $d->last_name }}</td>
                                    <td>{{ $d->username }}</td>
                                    <td>{{ $d->email }}</td>
                                    <td>@if(!empty($d->role())) {{ $d->role()->title }} @endif</td>
                                    <td class="actions">
                                        @if($d->reset_hash)
                                            <a class='clipboard-btn' data-toggle="tooltip" title="Copy reset link" data-clipboard-text="{{ route('resetUserPassword', ['hash' => $d->reset_hash]) }}"><i class="fa fa-lock fa-2x" style="color: green;"></i></a>
                                        @else
                                            <a class="reset-user-password" href="{{ route('resetUser', ['id' => $d->id ]) }}" data-toggle="tooltip" title="Reset user password"><i class="fa fa-unlock fa-2x" style="color: green;"></i></a>
                                        @endif
                                        <a href="{{ route('modifyUser', $d->id) }}"><i class="fa fa-pencil-alt fa-2x" style="color: orange;"></i></a>
                                        <a href="{{ route('deleteUser', $d->id) }}" class="delete-row"><i class="fa fa-trash-alt fa-2x" style="color: #ed180e;"></i></a>
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