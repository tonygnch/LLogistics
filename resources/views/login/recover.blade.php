@extends('login-layout')
@section('content')
    <!-- start: page -->
    <section class="body-sign">
        <div class="center-sign">
            <a href="/" class="logo pull-left">
                <img src="/assets/images/logo.png" height="54" alt="Porto Admin" />
            </a>

            <div class="panel panel-sign">
                <div class="panel-title-sign mt-xl text-right">
                    <h2 class="title text-uppercase text-bold m-none"><i class="fa fa-user mr-xs"></i> Reset Password</h2>
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route('resetUserPassword', ['hash' => $hash]) }}">
                        <div class="form-group mb-none">
                            <div class="row">
                                <div class="col-sm-12 mb-lg">
                                    <label>Password</label>
                                    <input name="password" type="password" class="form-control input-lg" />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <button type="submit" class="btn btn-primary hidden-xs">Recover</button>
                                <button type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg">Recover</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection