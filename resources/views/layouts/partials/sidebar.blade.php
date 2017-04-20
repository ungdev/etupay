<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        @if (! Auth::guest())
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{asset('/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>
        @endif

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">Menu</li>
            <!-- Optionally, you can add icons to the links -->
            <li><a href="{{ route('dashboard.index') }}"><i class='fa fa-link'></i> <span>Home</span></a></li>
            <li class="treeview">
                <a href="#"><i class='glyphicon glyphicon-globe'></i> <span>Gestion des services</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('dashboard.services.index') }}">Listes</a></li>
                    <li><a href="#">Création d'un service</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><i class='glyphicon glyphicon-shopping-cart'></i> <span>Exports</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="#">Téléchargement</a></li>
                    <li><a href="#">Cloture de compte</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><i class='glyphicon glyphicon-user'></i> <span>Gestion utilisateurs</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="#">Liste</a></li>
                    <li><a href="#">Export</a></li>
                </ul>
            </li>
            <li><a href="#"><i class='glyphicon glyphicon-book'></i> <span>Documentation</span></a></li>
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
