<!-- Navbar-->
<header class="main-header-top hidden-print">
    <a href="/celestadmin" class="logo">
        {{-- <img class="img-fluid able-logo" src="https://cdn.qenium.com//assets/img/qenium.png" alt="Qenium"> --}}
        <div style="font-size: 30px; font-family: 'PT Sans', sans-serif;">CelestAdmin</div>
    </a>
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#!" data-toggle="offcanvas" class="sidebar-toggle"></a>
        <ul class="top-nav lft-nav">
            {{-- <li>
                <a href="#!" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle drop icon-circle drop-image">
                    <i class="ti ti-files"> </i><span> Files</span>
                </a>
            </li> --}}
            <li class="dropdown">
                <a href="#!" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle drop icon-circle drop-image">
                    <span>{{ config('app.name', 'Laravel') }} </span><i class=" icofont icofont-simple-down"></i>
                </a>
                <ul class="dropdown-menu settings-menu">
                    <li><a href="{{ url('/') }}" target="_blank">Allez au site</a></li>
                </ul>
            </li>
            {{-- <li class="dropdown pc-rheader-submenu message-notification search-toggle">
                <a href="#" id="morphsearch-search" class="drop icon-circle txt-white">
                    <i class="ti ti-search"></i>
                </a>
            </li> --}}
        </ul>
        <!-- Navbar Right Menu-->
        <div class="navbar-custom-menu">
            <ul class="top-nav">
                <!--Notification Menu-->
                {{-- <li class="dropdown notification-menu">
                    <a href="#!" data-toggle="dropdown" aria-expanded="false" class="dropdown-toggle">
                        <i class="icon-bell"></i>
                        <span class="badge badge-danger header-badge">9</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="not-head">You have <b class="text-primary">4</b> new notifications.</li>
                        <li class="bell-notification">
                            <a href="javascript:;" class="media">
                                <span class="media-left media-icon">
                                    <img class="img-circle" src="https://cdn.qenium.com//assets/images/avatar-1.png" alt="User Image">
                                </span>
                                <div class="media-body"><span class="block">Lisa sent you a mail</span><span class="text-muted block-time">2min ago</span></div>
                            </a>
                        </li>
                        <li class="bell-notification">
                            <a href="javascript:;" class="media">
                                <span class="media-left media-icon">
                                    <img class="img-circle" src="https://cdn.qenium.com//assets/images/avatar-2.png" alt="User Image">
                                </span>
                                <div class="media-body"><span class="block">Server Not Working</span><span class="text-muted block-time">20min ago</span></div>
                            </a>
                        </li>
                        <li class="bell-notification">
                            <a href="javascript:;" class="media"><span class="media-left media-icon">
                                <img class="img-circle" src="https://cdn.qenium.com//assets/images/avatar-3.png" alt="User Image">
                            </span>
                            <div class="media-body"><span class="block">Transaction xyz complete</span><span class="text-muted block-time">3 hours ago</span></div></a>
                        </li>
                        <li class="not-footer">
                            <a href="#!">See all notifications.</a>
                        </li>
                    </ul>
                </li> --}}
                <!-- chat dropdown -->
                {{-- <li class="pc-rheader-submenu ">
                    <a href="#!" class="drop icon-circle displayChatbox">
                        <i class="icon-bubbles"></i>
                        <span class="badge badge-danger header-badge">5</span>
                    </a>
                </li> --}}
                <!-- window screen -->
                <li class="pc-rheader-submenu">
                    <a href="#!" class="drop icon-circle" onclick="javascript:toggleFullScreen()">
                        <i class="icon-size-fullscreen"></i>
                    </a>

                </li>
                <!-- User Menu-->
                <li class="dropdown">
                    <a href="#!" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle drop icon-circle drop-image">
                        <span><img class="img-circle " src="https://cdn.qenium.com//assets/images/avatar-blank.jpg" style="width:40px;" alt="User Image"></span>
                        <span>{{ Auth::user()->name }} <b>{{ Auth::user()->prenom }}</b> <i class=" icofont icofont-simple-down"></i></span>

                    </a>
                    <ul class="dropdown-menu settings-menu">
                        {{-- <li><a href="#"><i class="icon-settings"></i> Paramètres</a></li>
                        <li><a href="#"><i class="icon-user"></i> Mon profil</a></li>
                        <li><a href="#"><i class="icon-envelope-open"></i> Messagerie</a></li>
                        <li class="p-0">
                            <div class="dropdown-divider m-0"></div>
                        </li>
                        <li><a href="#"><i class="icon-lock"></i> Lock Screen</a></li> --}}
                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <i class="icon-logout"></i>
                                Déconnexion
                            </a>
                        </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </ul>
                </li>
            </ul>

            <!-- search -->
            <div id="morphsearch" class="morphsearch">
                <form class="morphsearch-form">

                    <input class="morphsearch-input" type="search" placeholder="Search..." />

                    <button class="morphsearch-submit" type="submit">Search</button>

                </form>
                {{-- <div class="morphsearch-content">
                    <div class="dummy-column">
                        <h2>People</h2>
                        <a class="dummy-media-object" href="#!">
                            <img class="round" src="http://0.gravatar.com/avatar/81b58502541f9445253f30497e53c280?s=50&d=identicon&r=G" alt="Sara Soueidan" />
                            <h3>Sara Soueidan</h3>
                        </a>

                        <a class="dummy-media-object" href="#!">
                            <img class="round" src="http://1.gravatar.com/avatar/9bc7250110c667cd35c0826059b81b75?s=50&d=identicon&r=G" alt="Shaun Dona" />
                            <h3>Shaun Dona</h3>
                        </a>
                    </div>
                    <div class="dummy-column">
                        <h2>Popular</h2>
                        <a class="dummy-media-object" href="#!">
                            <img src="https://cdn.qenium.com//assets/images/avatar-1.png" alt="PagePreloadingEffect" />
                            <h3>Page Preloading Effect</h3>
                        </a>

                        <a class="dummy-media-object" href="#!">
                            <img src="https://cdn.qenium.com//assets/images/avatar-1.png" alt="DraggableDualViewSlideshow" />
                            <h3>Draggable Dual-View Slideshow</h3>
                        </a>
                    </div>
                    <div class="dummy-column">
                        <h2>Recent</h2>
                        <a class="dummy-media-object" href="#!">
                            <img src="https://cdn.qenium.com//assets/images/avatar-1.png" alt="TooltipStylesInspiration" />
                            <h3>Tooltip Styles Inspiration</h3>
                        </a>
                        <a class="dummy-media-object" href="#!">
                            <img src="https://cdn.qenium.com//assets/images/avatar-1.png" alt="NotificationStyles" />
                            <h3>Notification Styles Inspiration</h3>
                        </a>
                    </div>
                </div> --}}
                <!-- /morphsearch-content -->
                <span class="morphsearch-close"><i class="icofont icofont-search-alt-1"></i></span>
            </div>
            <!-- search end -->
        </div>
    </nav>
</header>
<!-- Side-Nav-->
<aside class="main-sidebar hidden-print ">
    <section class="sidebar" id="sidebar-scroll">
        <!-- Sidebar Menu-->
        <ul class="sidebar-menu">
            <li class="treeview">
                <a class="waves-effect waves-dark" href="/celestadmin">
                    <i class="ti ti-dashboard text-purple"></i><span> Tableau de bord</span>
                </a>
            </li>
            {{-- <li class="nav-level">---- <span> Configuration</span></li>
            <li class="treeview">
                <a class="waves-effect waves-dark" href="#!">
                    <i class="ti ti-settings text-purple"></i>

                    <span>Configuration</span>
                    <i class="icon-arrow-down"></i>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a class="waves-effect waves-dark" href="#">
                            <i class="icon-arrow-right"></i> Site web
                        </a>
                    </li>
                    <li>
                        <a class="waves-effect waves-dark" href="#">
                            <i class="icon-arrow-right"></i> Rubrique
                        </a>
                    </li>
                    <li>
                        <a class="waves-effect waves-dark" href="#">
                            <i class="icon-arrow-right"></i> Design Rubrique
                        </a>
                    </li>
                    <li>
                        <a class="waves-effect waves-dark" href="#">
                            <i class="icon-arrow-right"></i> Privilèges utilisateur
                        </a>
                    </li>
                    <li>
                        <a class="waves-effect waves-dark" href="#">
                            <i class="icon-arrow-right"></i> Champs article
                        </a>
                    </li>
                </ul>
            </li> --}}
            @php($mySlug = 'celestadmin/'.$infosPage['slug'])
            @php($menu = menu(29))
            @foreach ($menu as $menu)
                @if (empty($menu->parent))
                    @php($active = null)
                    {{-- Selectionner le menu en cours --}}
                    @if (count($menu->childrens) > 0)
                        @php($nPermission = 0)
                        @foreach ($menu->childrens as $submenu)
                            @empty($submenu->requete)
                                @if ($submenu->lien == $mySlug)
                                    @php($active = 'active')
                                    {{-- @break --}}
                                @endif
                                @can($submenu->sous_titre)
                                    @php($nPermission++)
                                @endcan
                            @else
                                @php($occurences = DB::select($submenu->requete))
                                @foreach ($occurences as $occurence)
                                    @if ($menu->slug == 'post')
                                        @php($myLink = 'celestadmin/p/'.$occurence->slug)
                                    @else
                                        @php($myLink = 'celestadmin/'.$occurence->slug)
                                    @endif
                                    @if (($myLink) == $mySlug)
                                        @php($active = 'active')
                                        {{-- @break --}}
                                    @endif
                                    @can($submenu->sous_titre.' '.$occurence->slug.' index')
                                        @php($nPermission++)
                                    @endcan
                                @endforeach
                            @endempty
                        @endforeach
                    @else
                        @if (($menu->lien) == $mySlug)
                            @php($active = 'active')
                        @endif
                    @endif
                    @if ($nPermission > 0)
                        <li class="{!! (count($menu->childrens) > 0) ? 'treeview' : '' !!} {{ $active }}">
                            <a class="waves-effect waves-dark" href="{!! (count($menu->childrens) > 0) ? '#' : url($menu->lien) !!}">
                                <i class="{{ $menu->icon }} text-warning-color"></i>
                                <span>{{ $menu->libelle }}</span>
                                {!! (count($menu->childrens) > 0) ? '<i class="icon-arrow-down"></i>' : '' !!}
                            </a>
                            @if (count($menu->childrens) > 0)
                                <ul class="treeview-menu">
                                    @foreach ($menu->childrens as $submenu)
                                        @empty($submenu->requete)
                                            @can($submenu->sous_titre)
                                                <li {!! (($submenu->lien) == $mySlug) ? 'class="active"' : '' !!}>
                                                    <a class="waves-effect waves-dark" href="{{ url($submenu->lien) }}">
                                                        <i class="icon-arrow-right"></i>
                                                        {{ $submenu->libelle }}
                                                    </a>
                                                </li>
                                            @endcan
                                        @else
                                            @php($occurences = DB::select($submenu->requete))
                                            @foreach ($occurences as $occurence)
                                                @if ($menu->slug == 'post')
                                                    @php($myLink = 'celestadmin/p/'.$occurence->slug)
                                                @else
                                                    @php($myLink = 'celestadmin/'.$occurence->slug)
                                                @endif
                                                @can($submenu->sous_titre.' '.$occurence->slug.' index')
                                                    <li {!! (($myLink) == $mySlug) ? 'class="active"' : '' !!}>
                                                        <a class="waves-effect waves-dark" href="{{ url($myLink) }}">
                                                            <i class="icon-arrow-right"></i>
                                                            {{ $occurence->libelle }}
                                                        </a>
                                                    </li>
                                                @endcan
                                            @endforeach
                                        @endempty
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endif
                @endif
            @endforeach

            {{-- <li><a class="waves-effect waves-dark" href="typography.html"><i class="ti ti-smallcap text-danger-color"></i> <span>Catégorie</span></a></li> --}}

            {{--<li class="treeview">
                <a class="waves-effect waves-dark" href="#!">
                    <i class="ti ti-ruler-pencil text-danger"></i>
                    <span>Option</span>
                    <i class="icon-arrow-down"></i>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a class="waves-effect waves-dark" href="/celestadmin/type-option">
                            <i class="icon-arrow-right"></i> Type option
                        </a>
                    </li>
                    <li>
                        <a class="waves-effect waves-dark" href="/celestadmin/option">
                            <i class="icon-arrow-right"></i> Option
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-level">---- <span>Administration</span></li>
            <li class="treeview">
                <a href="{{ url('celestadmin/categorie') }}">
                    <i class="ti ti-book text-info-color"></i>
                    <span> Catégories</span>
                </a>
            </li>
            <li class="treeview">
                <a href="{{ url('celestadmin/marque-modele') }}">
                    <i class="icofont-brand-axiata text-success-color"></i>
                    <span>Marques & Modèles</span>
                </a>
            </li>
            <li class="treeview">
                <a href="{{ url('celestadmin/web/annonce') }}">
                    <i class="ti ti-layout-grid3-alt text-primary-color"></i>
                    <span> Annonces</span>
                </a>
            </li>
            <li class="treeview">
                <a href="{{ url('celestadmin/user') }}">
                    <i class="ti ti-user text-primary-color"></i>
                    <span> Utilisateurs</span>
                </a>
            </li>  --}}

            {{-- <li class="treeview">
                <a class="waves-effect waves-dark" href="#!">
                    <i class="ti ti-image text-purple"></i>
                    <span> Article</span>
                    <i class="icon-arrow-down"></i>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a class="waves-effect waves-dark" href="#">
                            <i class="icon-arrow-right"></i> Slider
                        </a>
                    </li>
                    <li>
                        <a class="waves-effect waves-dark" href="#">
                            <i class="icon-arrow-right"></i> Blog
                        </a>
                    </li>
                </ul>
            </li> --}}
            {{-- <li class="treeview">
                <a class="waves-effect waves-dark" href="#!">
                    <i class="ti ti-image text-purple"></i>
                    <span> Utilisateurs</span>
                    <i class="icon-arrow-down"></i>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a class="waves-effect waves-dark" href="{{url('celestadmin/user')}}">
                            <i class="icon-arrow-right"></i> Tous les utilisateurs
                        </a>
                    </li>
                    <li>
                        <a class="waves-effect waves-dark" href="#">
                            <i class="icon-arrow-right"></i> Ajouter
                        </a>
                    </li>
                    <li>
                        <a class="waves-effect waves-dark" href="#">
                            <i class="icon-arrow-right"></i> Votre profil
                        </a>
                    </li>
                    <li>
                        <a class="waves-effect waves-dark" href="#">
                            <i class="icon-arrow-right"></i> Rôle
                        </a>
                    </li>
                </ul>
            </li> --}}
        </ul>
    </section>
</aside>
<!-- Sidebar chat start -->
{{-- <div id="sidebar" class="p-fixed header-users showChat">
    <div class="had-container">
        <div class="card card_main header-users-main">
            <div class="card-content user-box">
                <div class="md-group-add-on p-20">
                    <span class="md-add-on">
                        <i class="icofont icofont-search-alt-2 chat-search"></i>
                    </span>
                    <div class="md-input-wrapper">
                        <input type="text" class="md-form-control" name="username" id="search-friends">
                        <label for="username">Search</label>
                    </div>

                </div>
                <div class="media friendlist-main">

                    <h6>Friend List</h6>

                </div>
                <div class="main-friend-list">
                    <div class="media friendlist-box" data-id="1" data-status="online" data-username="Josephin Doe" data-toggle="tooltip" data-placement="left" title="Josephin Doe">

                        <a class="media-left" href="#!">
                            <img class="media-object img-circle" src="https://cdn.qenium.com//assets/images/avatar-1.png" alt="Generic placeholder image">
                            <div class="live-status bg-success"></div>
                        </a>
                        <div class="media-body">
                            <div class="friend-header">Josephin Doe</div>
                            <span>20min ago</span>
                        </div>
                    </div>
                    <div class="media friendlist-box" data-id="3" data-status="online" data-username="Alice" data-toggle="tooltip" data-placement="left" title="Alice">
                        <a class="media-left" href="#!">
                            <img class="media-object img-circle" src="https://cdn.qenium.com//assets/images/avatar-2.png" alt="Generic placeholder image">
                            <div class="live-status bg-success"></div>
                        </a>
                        <div class="media-body">
                            <div class="friend-header">Alice</div>
                            <span>1 hour ago</span>
                        </div>
                    </div>
                    <div class="media friendlist-box" data-id="7" data-status="offline" data-username="Michael Scofield" data-toggle="tooltip" data-placement="left" title="Michael Scofield">
                        <a class="media-left" href="#!">
                            <img class="media-object img-circle" src="https://cdn.qenium.com//assets/images/avatar-3.png" alt="Generic placeholder image">
                            <div class="live-status bg-danger"></div>
                        </a>
                        <div class="media-body">
                            <div class="friend-header">Michael Scofield</div>
                            <span>3 hours ago</span>
                        </div>
                    </div>
                    <div class="media friendlist-box" data-id="5" data-status="online" data-username="Irina Shayk" data-toggle="tooltip" data-placement="left" title="Irina Shayk">
                        <a class="media-left" href="#!">
                            <img class="media-object img-circle" src="https://cdn.qenium.com//assets/images/avatar-4.png" alt="Generic placeholder image">
                            <div class="live-status bg-success"></div>
                        </a>
                        <div class="media-body">
                            <div class="friend-header">Irina Shayk</div>
                            <span>1 day ago</span>
                        </div>
                    </div>
                    <div class="media friendlist-box" data-id="6" data-status="offline" data-username="Sara Tancredi" data-toggle="tooltip" data-placement="left" title="Sara Tancredi">
                        <a class="media-left" href="#!">
                            <img class="media-object img-circle" src="https://cdn.qenium.com//assets/images/avatar-5.png" alt="Generic placeholder image">
                            <div class="live-status bg-danger"></div>
                        </a>
                        <div class="media-body">
                            <div class="friend-header">Sara Tancredi</div>
                            <span>2 days ago</span>
                        </div>
                    </div>
                    <div class="media friendlist-box" data-id="1" data-status="online" data-username="Josephin Doe" data-toggle="tooltip" data-placement="left" title="Josephin Doe">
                        <a class="media-left" href="#!">
                            <img class="media-object img-circle" src="https://cdn.qenium.com//assets/images/avatar-1.png" alt="Generic placeholder image">
                            <div class="live-status bg-success"></div>
                        </a>
                        <div class="media-body">
                            <div class="friend-header">Josephin Doe</div>
                            <span>20min ago</span>
                        </div>
                    </div>
                    <div class="media friendlist-box" data-id="3" data-status="online" data-username="Alice" data-toggle="tooltip" data-placement="left" title="Alice">
                        <a class="media-left" href="#!">
                            <img class="media-object img-circle" src="https://cdn.qenium.com//assets/images/avatar-2.png" alt="Generic placeholder image">
                            <div class="live-status bg-success"></div>
                        </a>
                        <div class="media-body">
                            <div class="friend-header">Alice</div>
                            <span>1 hour ago</span>
                        </div>
                    </div>
                    <div class="media friendlist-box" data-id="1" data-status="online" data-username="Josephin Doe" data-toggle="tooltip" data-placement="left" title="Josephin Doe">

                        <a class="media-left" href="#!">
                            <img class="media-object img-circle" src="https://cdn.qenium.com//assets/images/avatar-1.png" alt="Generic placeholder image">
                            <div class="live-status bg-success"></div>
                        </a>
                        <div class="media-body">
                            <div class="friend-header">Josephin Doe</div>
                            <span>20min ago</span>
                        </div>
                    </div>
                    <div class="media friendlist-box" data-id="3" data-status="online" data-username="Alice" data-toggle="tooltip" data-placement="left" title="Alice">
                        <a class="media-left" href="#!">
                            <img class="media-object img-circle" src="https://cdn.qenium.com//assets/images/avatar-2.png" alt="Generic placeholder image">
                            <div class="live-status bg-success"></div>
                        </a>
                        <div class="media-body">
                            <div class="friend-header">Alice</div>
                            <span>1 hour ago</span>
                        </div>
                    </div>
                    <div class="media friendlist-box" data-id="1" data-status="online" data-username="Josephin Doe" data-toggle="tooltip" data-placement="left" title="Josephin Doe">

                        <a class="media-left" href="#!">
                            <img class="media-object img-circle" src="https://cdn.qenium.com//assets/images/avatar-1.png" alt="Generic placeholder image">
                            <div class="live-status bg-success"></div>
                        </a>
                        <div class="media-body">
                            <div class="friend-header">Josephin Doe</div>
                            <span>20min ago</span>
                        </div>
                    </div>
                    <div class="media friendlist-box" data-id="3" data-status="online" data-username="Alice" data-toggle="tooltip" data-placement="left" title="Alice">
                        <a class="media-left" href="#!">
                            <img class="media-object img-circle" src="https://cdn.qenium.com//assets/images/avatar-2.png" alt="Generic placeholder image">
                            <div class="live-status bg-success"></div>
                        </a>
                        <div class="media-body">
                            <div class="friend-header">Alice</div>
                            <span>1 hour ago</span>
                        </div>
                    </div>
                    <div class="media friendlist-box" data-id="1" data-status="online" data-username="Josephin Doe" data-toggle="tooltip" data-placement="left" title="Josephin Doe">

                        <a class="media-left" href="#!">
                            <img class="media-object img-circle" src="https://cdn.qenium.com//assets/images/avatar-1.png" alt="Generic placeholder image">
                            <div class="live-status bg-success"></div>
                        </a>
                        <div class="media-body">
                            <div class="friend-header">Josephin Doe</div>
                            <span>20min ago</span>
                        </div>
                    </div>
                    <div class="media friendlist-box" data-id="1" data-status="online" data-username="Josephin Doe" data-toggle="tooltip" data-placement="left" title="Josephin Doe">

                        <a class="media-left" href="#!">
                            <img class="media-object img-circle" src="https://cdn.qenium.com//assets/images/avatar-1.png" alt="Generic placeholder image">
                            <div class="live-status bg-success"></div>
                        </a>
                        <div class="media-body">
                            <div class="friend-header">Josephin Doe</div>
                            <span>20min ago</span>
                        </div>
                    </div>
                    <div class="media friendlist-box" data-id="1" data-status="online" data-username="Josephin Doe" data-toggle="tooltip" data-placement="left" title="Josephin Doe">

                        <a class="media-left" href="#!">
                            <img class="media-object img-circle" src="https://cdn.qenium.com//assets/images/avatar-1.png" alt="Generic placeholder image">
                            <div class="live-status bg-success"></div>
                        </a>
                        <div class="media-body">
                            <div class="friend-header">Josephin Doe</div>
                            <span>20min ago</span>
                        </div>
                    </div>
                    <div class="media friendlist-box" data-id="1" data-status="online" data-username="Josephin Doe" data-toggle="tooltip" data-placement="left" title="Josephin Doe">

                        <a class="media-left" href="#!">
                            <img class="media-object img-circle" src="https://cdn.qenium.com//assets/images/avatar-1.png" alt="Generic placeholder image">
                            <div class="live-status bg-success"></div>
                        </a>
                        <div class="media-body">
                            <div class="friend-header">Josephin Doe</div>
                            <span>20min ago</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="showChat_inner">
    <div class="media chat-inner-header">
        <a class="back_chatBox">
            <i class="icofont icofont-rounded-left"></i> Josephin Doe
        </a>
    </div>
    <div class="media chat-messages">
        <a class="media-left photo-table" href="#!">
            <img class="media-object img-circle m-t-5" src="https://cdn.qenium.com//assets/images/avatar-1.png" alt="Generic placeholder image">
            <div class="live-status bg-success"></div>
        </a>
        <div class="media-body chat-menu-content">
            <div class="">
                <p class="chat-cont">I'm just looking around. Will you tell me something about yourself?</p>
                <p class="chat-time">8:20 a.m.</p>
            </div>
        </div>
    </div>
    <div class="media chat-messages">
        <div class="media-body chat-menu-reply">
            <div class="">
                <p class="chat-cont">I'm just looking around. Will you tell me something about yourself?</p>
                <p class="chat-time">8:20 a.m.</p>
            </div>
        </div>
        <div class="media-right photo-table">
            <a href="#!">
                <img class="media-object img-circle m-t-5" src="https://cdn.qenium.com//assets/images/avatar-2.png" alt="Generic placeholder image">
                <div class="live-status bg-success"></div>
            </a>
        </div>
    </div>
    <div class="media chat-reply-box">
        <div class="md-input-wrapper">
            <input type="text" class="md-form-control" id="inputEmail" name="inputEmail">
            <label>Share your thoughts</label>
            <span class="highlight"></span>
            <span class="bar"></span> <button type="button" class="chat-send waves-effect waves-light">
                <i class="icofont icofont-location-arrow f-20 "></i>
            </button>

            <button type="button" class="chat-send waves-effect waves-light">
                <i class="icofont icofont-location-arrow f-20 "></i>
            </button>
        </div>

    </div>
</div> --}}

@include('flash::message')
