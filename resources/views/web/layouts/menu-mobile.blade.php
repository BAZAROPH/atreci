<!-- Toolbar for handheld devices-->
<div class="cz-handheld-toolbar">
    <div class="d-table table-fixed w-100">
        <a class="d-table-cell cz-handheld-toolbar-item" href="{{ url('/') }}">
            <span class="cz-handheld-toolbar-icon"><i class="czi-home"></i></span>
            <span class="cz-handheld-toolbar-label">Accueil</span>
        </a>
        {{-- <a class="d-table-cell cz-handheld-toolbar-item" href="{{ url('categories') }}">
            <span class="cz-handheld-toolbar-icon"><i class="icofont-listine-dots"></i></span>
            <span class="cz-handheld-toolbar-label">Catégorie</span>
        </a> --}}
        <a class="d-table-cell cz-handheld-toolbar-item" href="#sideNav" data-toggle="collapse" onclick="window.scrollTo(0, 0)">
            <span class="cz-handheld-toolbar-icon"><i class="czi-menu"></i></span>
            <span class="cz-handheld-toolbar-label">Menu</span>
        </a>
        <a class="d-table-cell cz-handheld-toolbar-item" href="#">
            <span class="cz-handheld-toolbar-icon">
                <i class="czi-cart"></i>
                <span class="badge badge-primary badge-pill ml-1">
                    {{ Cart::instance('shopping')->count() }}
                </span>
            </span>
            <span class="cz-handheld-toolbar-label">
                {{ devise(Cart::instance('shopping')->subtotal()) }}
            </span>
            @guest
            <a class="d-table-cell cz-handheld-toolbar-item" href="{{ url('login') }}">
                <span class="cz-handheld-toolbar-icon"><i class="czi-user-circle"></i></span>
                <span class="cz-handheld-toolbar-label">Connexion</span>
            </a>
        @else
            <a class="d-table-cell cz-handheld-toolbar-item" href="{{ url('profil') }}">
                <span class="cz-handheld-toolbar-icon"><i class="czi-user-circle"></i></span>
                <span class="cz-handheld-toolbar-label">
                    {{ auth()->user()->name }}
                </span>
            </a>
        @endguest
        </a>
    </div>
</div>
