<!-- start: sidebar -->
<?php
    $actualLink = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
<aside id="sidebar-left" class="sidebar-left">
    <div class="sidebar-header">
        <div class="sidebar-title" style="color: #abb4be;">
            Navigation
        </div>
        <div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
            <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
        </div>
    </div>

    <div class="nano">
        <div class="nano-content">
            <nav id="menu" class="nav-main" role="navigation">
                <ul class="nav nav-main">
                    <li class="nav-active">
                        <a href="/">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-parent @if(substr($actualLink, 0, strlen(route('trucks'))) == route('trucks'))) nav-expanded @endif">
                        <a>
                            <i class="fa fa-truck" aria-hidden="true"></i>
                            <span>Trucks</span>
                        </a>
                        <ul class="nav nav-children">
                            <li class="@if(route('trucks') == $actualLink)) nav-active @endif">
                                <a href="{{ route('trucks') }}">
                                    All trucks
                                </a>
                            </li>
                            <li class="@if(route('addTruck') == $actualLink) nav-active @endif">
                                <a href="{{ route('addTruck') }}">
                                    Add truck
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-parent @if(substr($actualLink, 0, strlen(route('trailers'))) == route('trailers'))) nav-expanded @endif">
                        <a>
                            <i class="fa fa-truck-loading" aria-hidden="true"></i>
                            <span>Trailers</span>
                        </a>
                        <ul class="nav nav-children">
                            <li class="@if(route('trailers') == $actualLink) nav-active @endif">
                                <a href="{{ route('trailers') }}">
                                    All trailers
                                </a>
                            </li>
                            <li class="@if(route('addTrailer') == $actualLink) nav-active @endif">
                                <a href="{{ route('addTrailer') }}">
                                    Add trailer
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-parent">
                        <a>
                            <i class="fa fa-file" aria-hidden="true"></i>
                            <span>Invoices</span>
                        </a>
                        <ul class="nav nav-children">
                            <li>
                                <a href="pages-signup.html">
                                    All Invoices
                                </a>
                            </li>
                            <li>
                                <a href="pages-signin.html">
                                    Create Invoice
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-parent">
                        <a>
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <span>Clients</span>
                        </a>
                        <ul class="nav nav-children">
                            <li>
                                <a href="pages-signup.html">
                                    All Clients
                                </a>
                            </li>
                            <li>
                                <a href="pages-signin.html">
                                    Add Client
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>

            <hr class="separator" />

            <div class="sidebar-widget widget-stats">
                <div class="widget-header">
                    <h6 style="color: #abb4be;">Company Stats</h6>
                    <div class="widget-toggle" style="color: #abb4be;">+</div>
                </div>
                <div class="widget-content">
                    <ul>
                        <li>
                            <span class="stats-title">Stat 1</span>
                            <span class="stats-complete">85%</span>
                            <div class="progress">
                                <div class="progress-bar progress-bar-primary progress-without-number" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 85%;">
                                    <span class="sr-only">85% Complete</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <span class="stats-title">Stat 2</span>
                            <span class="stats-complete">70%</span>
                            <div class="progress">
                                <div class="progress-bar progress-bar-primary progress-without-number" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: 70%;">
                                    <span class="sr-only">70% Complete</span>
                                </div>
                            </div>
                        </li>
                        <li>
                            <span class="stats-title">Stat 3</span>
                            <span class="stats-complete">2%</span>
                            <div class="progress">
                                <div class="progress-bar progress-bar-primary progress-without-number" role="progressbar" aria-valuenow="2" aria-valuemin="0" aria-valuemax="100" style="width: 2%;">
                                    <span class="sr-only">2% Complete</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>

</aside>
<!-- end: sidebar -->