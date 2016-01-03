<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                        <canvas id="user-icon" width="48" height="48" class="img-circle"></canvas>
                             </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear">
                                <span class="block m-t-xs">
                                    <strong class="font-bold">{{$currentUser->known_as}}</strong>
                             </span> <span class="text-muted text-xs block">{{ucfirst($currentUser->role)}} <b
                                            class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="profile.html">Profile</a></li>
                        <li><a href="contacts.html">Contacts</a></li>
                        <li><a href="mailbox.html">Mailbox</a></li>
                        <li class="divider"></li>
                        <li><a href="login.html">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    FR
                </div>
            </li>
            <li @if(Request::is('/')) class="active" @endif>
                <a href="/"><i class="fa fa-th-large"></i> <span class="nav-label">Dashboards</span></a>
            </li>
            @can('view_all_properties', $currentUser)
                <li @if(Request::is('properties*')) class="active" @endif>
                    <a href="/properties"><i class="fa fa-home"></i> <span class="nav-label">Properties</span></a>
                </li>
            @endcan
            @can('view_all_tenancies', $currentUser)
                <li @if(Request::is('tenancies*')) class="active" @endif>
                    <a href="/tenancies"><i class="fa fa-legal"></i> <span
                                class="nav-label">Tenancies</span> </a>
                </li>
            @else

            @endcan

        </ul>
    </div>
</nav>