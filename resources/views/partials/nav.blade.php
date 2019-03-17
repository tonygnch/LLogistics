<!-- start: sidebar -->
<?php
    $actualLink = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
<aside id="sidebar-left" class="sidebar-left">
    <div class="sidebar-header">
        <div class="sidebar-title" style="color: #abb4be;">
            Navigation
        </div>
        {{--<div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">--}}
            {{--<i class="fa fa-bars" aria-label="Toggle sidebar"></i>--}}
        {{--</div>--}}
    </div>

    <div class="nano">
        <div class="nano-content">
            <nav id="menu" class="nav-main" role="navigation">
                <ul class="nav nav-main">
                    <li class="@if(isset($main)) nav-active @endif">
                        <a href="/">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    @foreach($menus as $menu)
                        <li class="@if(isset($menu->submenus)) nav-parent @endif @if(substr($actualLink, 0, strlen(route($menu->route))) == route($menu->route))) nav-expanded nav-active @endif">
                            <a @if(!isset($menu->submenus)) href="{{ route($menu->route) }}" @endif>
                                <i class="fa {{ $menu->icon }}" aria-hidden="true"></i>
                                <span>{{ $menu->title }}</span>
                            </a>
                            @if(isset($menu->submenus))
                                <ul class="nav nav-children">
                                @foreach($menu->submenus as $submenu)
                                    <li class="@if(route($submenu->route) == $actualLink)) nav-active @endif">
                                        <a href="{{ route($submenu->route) }}">
                                            {{ $submenu->title }}
                                        </a>
                                    </li>
                                @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
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