<nav class="navbar navbar-expand-lg bg-body-tertiary p-3">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/about">About Us</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/contact">Contact</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/users">Users</a>
                </li>
            </ul>
            <form class="d-flex" role="search">
                @guest
                    <button class="btn btn-outline-primary mx-3"><a href="/login"
                            class="text-decoration-none">Login</a></button>
                    <button class="btn btn-outline-primary"><a href="/register"
                            class="text-decoration-none">Register</a></button>
                @endguest
                @auth
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Hello, {{auth()->user()->name}}
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/logout">Logout</a></li>
                        </ul>
                    </div>

                @endauth


            </form>
        </div>
    </div>
</nav>