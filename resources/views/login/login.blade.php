@extends('login-layout')
@section('content')
    <section class="body-sign" style="height: 90vh;">
        <div class="center-sign">
            <a href="/" class="logo pull-left">
                <img src="assets/images/logo.png" height="54" alt="Porto Admin" />
            </a>

            <div class="panel panel-sign">
                <div class="panel-title-sign mt-xl text-right">
                    <h2 class="title text-uppercase text-bold m-none"><i class="fa fa-user mr-xs"></i> Sign In</h2>
                </div>
                <div class="panel-body">
                    <form action="{{ route('login') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-lg">
                            <label>Username</label>
                            <div class="input-group input-group-icon">
                                <input name="credential" type="text" class="form-control input-lg" required/>
                                <span class="input-group-addon">
										<span class="icon icon-lg">
											<i class="fa fa-user"></i>
										</span>
									</span>
                            </div>
                        </div>

                        <div class="form-group mb-lg">
                            <div class="clearfix">
                                <label class="pull-left">Password</label>
                            </div>
                            <div class="input-group input-group-icon">
                                <input name="password" type="password" class="form-control input-lg" required/>
                                <span class="input-group-addon">
										<span class="icon icon-lg">
											<i class="fa fa-lock"></i>
										</span>
									</span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <button type="submit" class="btn btn-primary hidden-xs">Sign In</button>
                                <button type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg">Sign In</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{--<p class="text-center text-muted mt-md mb-md">&copy; Copyright 2018. All rights reserved. Template by <a href="https://colorlib.com">Colorlib</a>.</p>--}}
        </div>
    </section>
@endsection