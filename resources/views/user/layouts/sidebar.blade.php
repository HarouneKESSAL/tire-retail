<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('user')}}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Utilisateur</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Élément de Navigation - Tableau de Bord -->
    <li class="nav-item active">
        <a class="nav-link" href="{{route('user')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Tableau de bord</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Titre -->
    <div class="sidebar-heading">
        Boutique
    </div>
    <!--Commandes -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('user.order.index')}}">
            <i class="fas fa-hammer fa-chart-area"></i>
            <span>Commandes</span>
        </a>
    </li>

    <!-- Avis -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('user.productreview.index')}}">
            <i class="fas fa-comments"></i>
            <span>Avis</span></a>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Titre -->
    <div class="sidebar-heading">
        Articles
    </div>
    <!-- Commentaires -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('user.post-comment.index')}}">
            <i class="fas fa-comments fa-chart-area"></i>
            <span>Commentaires</span>
        </a>
    </li>
    <!-- Bouton Basculer la Barre Latérale -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
