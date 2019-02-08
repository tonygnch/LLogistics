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
                                <input name="username" type="text" class="form-control input-lg" required/>
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
                                <a href="pages-recover-password.html" class="pull-right">Lost Password?</a>
                            </div>
                            <div class="input-group input-group-icon">
                                <input name="pwd" type="password" class="form-control input-lg" required/>
                                <span class="input-group-addon">
										<span class="icon icon-lg">
											<i class="fa fa-lock"></i>
										</span>
									</span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-8">
                                <div class="checkbox-custom checkbox-default">
                                    <input id="RememberMe" name="rememberme" type="checkbox"/>
                                    <label for="RememberMe">Remember Me</label>
                                </div>
                            </div>
                            <div class="col-sm-4 text-right">
                                <button type="submit" class="btn btn-primary hidden-xs">Sign In</button>
                                <button type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg">Sign In</button>
                            </div>
                        </div>

                        <span class="mt-lg mb-lg line-thru text-center text-uppercase">
								<span>-</span>
							</span>

                        <p class="text-center"> <a href="pages-signup.html">Register</a>

                    </form>
                </div>
            </div>

            {{--<p class="text-center text-muted mt-md mb-md">&copy; Copyright 2018. All rights reserved. Template by <a href="https://colorlib.com">Colorlib</a>.</p>--}}
        </div>
    </section>
@endsection