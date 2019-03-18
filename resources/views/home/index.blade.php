@extends('layout')
@section('content')

    <!-- start: page -->
    <div class="row">

        <div class="col-md-6 col-lg-12 col-xl-6">
            <div class="row">
                <div class="col-md-12 col-lg-6 col-xl-6">
                    <section class="panel panel-featured-left panel-featured-primary">
                        <div class="panel-body">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon bg-primary">
                                        <i class="fa fa-male"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Drivers</h4>
                                        <div class="info">
                                            <strong class="amount">{{ $driversCount }}</strong>
                                        </div>
                                    </div>
                                    <div class="summary-footer">
                                        <a class="text-muted text-uppercase" href="{{ route('drivers') }}">(go to drivers)</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-md-12 col-lg-6 col-xl-6">
                    <section class="panel panel-featured-left panel-featured-secondary">
                        <div class="panel-body">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon bg-secondary">
                                        <i class="fa fa-usd"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Total Profit</h4>
                                        <div class="info">
                                            <strong class="amount">€ 14,890.30</strong>
                                        </div>
                                    </div>
                                    <div class="summary-footer">
                                        <a class="text-muted text-uppercase">(withdraw)</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-md-12 col-lg-6 col-xl-6">
                    <section class="panel panel-featured-left panel-featured-tertiary">
                        <div class="panel-body">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon bg-tertiary">
                                        <i class="fa fa-road"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Weeks's Trips</h4>
                                        <div class="info">
                                            <strong class="amount">{{ $tripsCount }}</strong>
                                        </div>
                                    </div>
                                    <div class="summary-footer">
                                        <a class="text-muted text-uppercase" href="{{ route('trips') }}">(view all)</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="col-md-12 col-lg-6 col-xl-6">
                    <section class="panel panel-featured-left panel-featured-quartenary">
                        <div class="panel-body">
                            <div class="widget-summary">
                                <div class="widget-summary-col widget-summary-col-icon">
                                    <div class="summary-icon bg-quartenary">
                                        <i class="fa fa-user"></i>
                                    </div>
                                </div>
                                <div class="widget-summary-col">
                                    <div class="summary">
                                        <h4 class="title">Clients</h4>
                                        <div class="info">
                                            <strong class="amount">{{ $clientsCount }}</strong>
                                        </div>
                                    </div>
                                    <div class="summary-footer">
                                        <a class="text-muted text-uppercase" href="{{ route('clients') }}">(go to clients)</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12">
            <section class="panel">
                <header class="panel-heading panel-heading-transparent">
                    <div class="panel-actions">
                        <a href="#" class="fa fa-caret-down"></a>
                        <a href="#" class="fa fa-times"></a>
                    </div>

                    <h2 class="panel-title">Trips</h2>
                </header>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped mb-none">
                            <thead>
                            <tr>
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
                                <th>Actions</th>
                            </tr>
                            </tr>
                            </thead>
                            <tbody>
                            @if(!empty($homeTrips))
                                @foreach($homeTrips as $homeTrip)
                                    <tr>
                                        <td>@if(!empty($homeTrip->client())) {{ $homeTrip->client()->name }} @endif</td>
                                        <td>@if(!empty($homeTrip->driver())) {{ $homeTrip->driver()->name }} {{$homeTrip->driver()->surname}} @endif</td>
                                        <td>@if(!empty($homeTrip->truck())) {{ $homeTrip->truck()->plate }} - {{ $homeTrip->truck()->make }} @endif</td>
                                        <td>@if(!empty($homeTrip->trailer())) {{ $homeTrip->trailer()->plate }} - {{ $homeTrip->trailer()->make }} @endif</td>
                                        <td>{{ $homeTrip->description }}</td>
                                        <td>{{ date('d M Y', strtotime($homeTrip->departed)) }}</td>
                                        <td>{{ date('d M Y', strtotime($homeTrip->arrived)) }}</td>
                                        <td>{{ $homeTrip->start_point }}</td>
                                        <td>{{ $homeTrip->end_point }}</td>
                                        <td>{{ $homeTrip->distance }}</td>
                                        <td class="actions">
                                            <a href="{{ route('modifyTrip', $homeTrip->id) }}"><i class="fa fa-pencil-alt fa-2x" style="color: orange;"></i></a>
                                            <a href="{{ route('deleteTrip', $homeTrip->id) }}" class="delete-row"><i class="fa fa-trash-alt fa-2x" style="color: #ed180e;"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>

    {{--<div class="row">--}}
        {{--<div class="col-xl-3 col-lg-6">--}}
            {{--<section class="panel panel-transparent">--}}
                {{--<header class="panel-heading">--}}
                    {{--<div class="panel-actions">--}}
                        {{--<a href="#" class="fa fa-caret-down"></a>--}}
                        {{--<a href="#" class="fa fa-times"></a>--}}
                    {{--</div>--}}

                    {{--<h2 class="panel-title">My Profile</h2>--}}
                {{--</header>--}}
                {{--<div class="panel-body">--}}
                    {{--<section class="panel panel-group">--}}
                        {{--<header class="panel-heading bg-primary">--}}

                            {{--<div class="widget-profile-info">--}}
                                {{--<div class="profile-picture">--}}
                                    {{--<img src="assets/images/!logged-user.jpg">--}}
                                {{--</div>--}}
                                {{--<div class="profile-info">--}}
                                    {{--<h4 class="name text-semibold">John Doe</h4>--}}
                                    {{--<h5 class="role">Administrator</h5>--}}
                                    {{--<div class="profile-footer">--}}
                                        {{--<a href="#">(edit profile)</a>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}

                        {{--</header>--}}
                        {{--<div id="accordion">--}}
                            {{--<div class="panel panel-accordion panel-accordion-first">--}}
                                {{--<div class="panel-heading">--}}
                                    {{--<h4 class="panel-title">--}}
                                        {{--<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"--}}
                                           {{--href="#collapse1One">--}}
                                            {{--<i class="fa fa-check"></i> Tasks--}}
                                        {{--</a>--}}
                                    {{--</h4>--}}
                                {{--</div>--}}
                                {{--<div id="collapse1One" class="accordion-body collapse in">--}}
                                    {{--<div class="panel-body">--}}
                                        {{--<ul class="widget-todo-list">--}}
                                            {{--<li>--}}
                                                {{--<div class="checkbox-custom checkbox-default">--}}
                                                    {{--<input type="checkbox" checked="" id="todoListItem1"--}}
                                                           {{--class="todo-check">--}}
                                                    {{--<label class="todo-label" for="todoListItem1"><span>Lorem ipsum dolor sit amet</span></label>--}}
                                                {{--</div>--}}
                                                {{--<div class="todo-actions">--}}
                                                    {{--<a class="todo-remove" href="#">--}}
                                                        {{--<i class="fa fa-times"></i>--}}
                                                    {{--</a>--}}
                                                {{--</div>--}}
                                            {{--</li>--}}
                                            {{--<li>--}}
                                                {{--<div class="checkbox-custom checkbox-default">--}}
                                                    {{--<input type="checkbox" id="todoListItem2" class="todo-check">--}}
                                                    {{--<label class="todo-label" for="todoListItem2"><span>Lorem ipsum dolor sit amet</span></label>--}}
                                                {{--</div>--}}
                                                {{--<div class="todo-actions">--}}
                                                    {{--<a class="todo-remove" href="#">--}}
                                                        {{--<i class="fa fa-times"></i>--}}
                                                    {{--</a>--}}
                                                {{--</div>--}}
                                            {{--</li>--}}
                                            {{--<li>--}}
                                                {{--<div class="checkbox-custom checkbox-default">--}}
                                                    {{--<input type="checkbox" id="todoListItem3" class="todo-check">--}}
                                                    {{--<label class="todo-label" for="todoListItem3"><span>Lorem ipsum dolor sit amet</span></label>--}}
                                                {{--</div>--}}
                                                {{--<div class="todo-actions">--}}
                                                    {{--<a class="todo-remove" href="#">--}}
                                                        {{--<i class="fa fa-times"></i>--}}
                                                    {{--</a>--}}
                                                {{--</div>--}}
                                            {{--</li>--}}
                                            {{--<li>--}}
                                                {{--<div class="checkbox-custom checkbox-default">--}}
                                                    {{--<input type="checkbox" id="todoListItem4" class="todo-check">--}}
                                                    {{--<label class="todo-label" for="todoListItem4"><span>Lorem ipsum dolor sit amet</span></label>--}}
                                                {{--</div>--}}
                                                {{--<div class="todo-actions">--}}
                                                    {{--<a class="todo-remove" href="#">--}}
                                                        {{--<i class="fa fa-times"></i>--}}
                                                    {{--</a>--}}
                                                {{--</div>--}}
                                            {{--</li>--}}
                                            {{--<li>--}}
                                                {{--<div class="checkbox-custom checkbox-default">--}}
                                                    {{--<input type="checkbox" id="todoListItem5" class="todo-check">--}}
                                                    {{--<label class="todo-label" for="todoListItem5"><span>Lorem ipsum dolor sit amet</span></label>--}}
                                                {{--</div>--}}
                                                {{--<div class="todo-actions">--}}
                                                    {{--<a class="todo-remove" href="#">--}}
                                                        {{--<i class="fa fa-times"></i>--}}
                                                    {{--</a>--}}
                                                {{--</div>--}}
                                            {{--</li>--}}
                                            {{--<li>--}}
                                                {{--<div class="checkbox-custom checkbox-default">--}}
                                                    {{--<input type="checkbox" id="todoListItem6" class="todo-check">--}}
                                                    {{--<label class="todo-label" for="todoListItem6"><span>Lorem ipsum dolor sit amet</span></label>--}}
                                                {{--</div>--}}
                                                {{--<div class="todo-actions">--}}
                                                    {{--<a class="todo-remove" href="#">--}}
                                                        {{--<i class="fa fa-times"></i>--}}
                                                    {{--</a>--}}
                                                {{--</div>--}}
                                            {{--</li>--}}
                                        {{--</ul>--}}
                                        {{--<hr class="solid mt-sm mb-lg">--}}
                                        {{--<form method="get" class="form-horizontal form-bordered">--}}
                                            {{--<div class="form-group">--}}
                                                {{--<div class="col-sm-12">--}}
                                                    {{--<div class="input-group mb-md">--}}
                                                        {{--<input type="text" class="form-control">--}}
                                                        {{--<div class="input-group-btn">--}}
                                                            {{--<button type="button" class="btn btn-primary" tabindex="-1">--}}
                                                                {{--Add--}}
                                                            {{--</button>--}}
                                                        {{--</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                            {{--</div>--}}
                                        {{--</form>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="panel panel-accordion">--}}
                                {{--<div class="panel-heading">--}}
                                    {{--<h4 class="panel-title">--}}
                                        {{--<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"--}}
                                           {{--href="#collapse1Two">--}}
                                            {{--<i class="fa fa-comment"></i> Messages--}}
                                        {{--</a>--}}
                                    {{--</h4>--}}
                                {{--</div>--}}
                                {{--<div id="collapse1Two" class="accordion-body collapse">--}}
                                    {{--<div class="panel-body">--}}
                                        {{--<ul class="simple-user-list mb-xlg">--}}
                                            {{--<li>--}}
                                                {{--<figure class="image rounded">--}}
                                                    {{--<img src="assets/images/!sample-user.jpg" alt="Joseph Doe Junior"--}}
                                                         {{--class="img-circle">--}}
                                                {{--</figure>--}}
                                                {{--<span class="title">Joseph Doe Junior</span>--}}
                                                {{--<span class="message">Lorem ipsum dolor sit.</span>--}}
                                            {{--</li>--}}
                                            {{--<li>--}}
                                                {{--<figure class="image rounded">--}}
                                                    {{--<img src="assets/images/!sample-user.jpg" alt="Joseph Junior"--}}
                                                         {{--class="img-circle">--}}
                                                {{--</figure>--}}
                                                {{--<span class="title">Joseph Junior</span>--}}
                                                {{--<span class="message">Lorem ipsum dolor sit.</span>--}}
                                            {{--</li>--}}
                                            {{--<li>--}}
                                                {{--<figure class="image rounded">--}}
                                                    {{--<img src="assets/images/!sample-user.jpg" alt="Joe Junior"--}}
                                                         {{--class="img-circle">--}}
                                                {{--</figure>--}}
                                                {{--<span class="title">Joe Junior</span>--}}
                                                {{--<span class="message">Lorem ipsum dolor sit.</span>--}}
                                            {{--</li>--}}
                                            {{--<li>--}}
                                                {{--<figure class="image rounded">--}}
                                                    {{--<img src="assets/images/!sample-user.jpg" alt="Joseph Doe Junior"--}}
                                                         {{--class="img-circle">--}}
                                                {{--</figure>--}}
                                                {{--<span class="title">Joseph Doe Junior</span>--}}
                                                {{--<span class="message">Lorem ipsum dolor sit.</span>--}}
                                            {{--</li>--}}
                                        {{--</ul>--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</section>--}}

                {{--</div>--}}
            {{--</section>--}}
        {{--</div>--}}
        {{--<div class="col-xl-3 col-lg-6">--}}
            {{--<section class="panel panel-transparent">--}}
                {{--<header class="panel-heading">--}}
                    {{--<div class="panel-actions">--}}
                        {{--<a href="#" class="fa fa-caret-down"></a>--}}
                        {{--<a href="#" class="fa fa-times"></a>--}}
                    {{--</div>--}}

                    {{--<h2 class="panel-title">My Stats</h2>--}}
                {{--</header>--}}
                {{--<div class="panel-body">--}}
                    {{--<section class="panel">--}}
                        {{--<div class="panel-body">--}}
                            {{--<div class="small-chart pull-right" id="sparklineBarDash"></div>--}}
                            {{--<script type="text/javascript">--}}
                                {{--var sparklineBarDashData = [5, 6, 7, 2, 0, 4, 2, 4, 2, 0, 4, 2, 4, 2, 0, 4];--}}
                            {{--</script>--}}
                            {{--<div class="h4 text-bold mb-none">488</div>--}}
                            {{--<p class="text-xs text-muted mb-none">Average Profile Visits</p>--}}
                        {{--</div>--}}
                    {{--</section>--}}
                    {{--<section class="panel">--}}
                        {{--<div class="panel-body">--}}
                            {{--<div class="circular-bar circular-bar-xs m-none mt-xs mr-md pull-right">--}}
                                {{--<div class="circular-bar-chart" data-percent="45"--}}
                                     {{--data-plugin-options='{ "barColor": "#2baab1", "delay": 300, "size": 50, "lineWidth": 4 }'>--}}
                                    {{--<strong>Average</strong>--}}
                                    {{--<label><span class="percent">45</span>%</label>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="h4 text-bold mb-none">12</div>--}}
                            {{--<p class="text-xs text-muted mb-none">Working Projects</p>--}}
                        {{--</div>--}}
                    {{--</section>--}}
                    {{--<section class="panel">--}}
                        {{--<div class="panel-body">--}}
                            {{--<div class="small-chart pull-right" id="sparklineLineDash"></div>--}}
                            {{--<script type="text/javascript">--}}
                                {{--var sparklineLineDashData = [15, 16, 17, 19, 10, 15, 13, 12, 12, 14, 16, 17];--}}
                            {{--</script>--}}
                            {{--<div class="h4 text-bold mb-none">89</div>--}}
                            {{--<p class="text-xs text-muted mb-none">Pending Tasks</p>--}}
                        {{--</div>--}}
                    {{--</section>--}}
                {{--</div>--}}
            {{--</section>--}}
            {{--<section class="panel">--}}
                {{--<header class="panel-heading">--}}
                    {{--<div class="panel-actions">--}}
                        {{--<a href="#" class="fa fa-caret-down"></a>--}}
                        {{--<a href="#" class="fa fa-times"></a>--}}
                    {{--</div>--}}

                    {{--<h2 class="panel-title">--}}
                        {{--<span class="label label-primary label-sm text-normal va-middle mr-sm">198</span>--}}
                        {{--<span class="va-middle">Friends</span>--}}
                    {{--</h2>--}}
                {{--</header>--}}
                {{--<div class="panel-body">--}}
                    {{--<div class="content">--}}
                        {{--<ul class="simple-user-list">--}}
                            {{--<li>--}}
                                {{--<figure class="image rounded">--}}
                                    {{--<img src="assets/images/!sample-user.jpg" alt="Joseph Doe Junior"--}}
                                         {{--class="img-circle">--}}
                                {{--</figure>--}}
                                {{--<span class="title">Joseph Doe Junior</span>--}}
                                {{--<span class="message truncate">Lorem ipsum dolor sit.</span>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<figure class="image rounded">--}}
                                    {{--<img src="assets/images/!sample-user.jpg" alt="Joseph Junior" class="img-circle">--}}
                                {{--</figure>--}}
                                {{--<span class="title">Joseph Junior</span>--}}
                                {{--<span class="message truncate">Lorem ipsum dolor sit.</span>--}}
                            {{--</li>--}}
                            {{--<li>--}}
                                {{--<figure class="image rounded">--}}
                                    {{--<img src="assets/images/!sample-user.jpg" alt="Joe Junior" class="img-circle">--}}
                                {{--</figure>--}}
                                {{--<span class="title">Joe Junior</span>--}}
                                {{--<span class="message truncate">Lorem ipsum dolor sit.</span>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                        {{--<hr class="dotted short">--}}
                        {{--<div class="text-right">--}}
                            {{--<a class="text-uppercase text-muted" href="#">(View All)</a>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="panel-footer">--}}
                    {{--<div class="input-group input-search">--}}
                        {{--<input type="text" class="form-control" name="q" id="q" placeholder="Search...">--}}
                        {{--<span class="input-group-btn">--}}
                                        {{--<button class="btn btn-default" type="submit"><i class="fa fa-search"></i>--}}
                                        {{--</button>--}}
                                    {{--</span>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</section>--}}
        {{--</div>--}}
    {{--</div>--}}
    <!-- end: page -->
@endsection