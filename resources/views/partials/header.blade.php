<nav class="navbar navbar-expand-lg sticky-top" style="background: white; box-shadow: 0 2px 15px rgba(0,0,0,0.08); padding: 12px 0;">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}" style="display: flex; align-items: center; gap: 8px;">
            <img src="{{ asset('img/assets/Exachanger Logo.png') }}" alt="Exachanger Logo" style="height: 35px;">
            <span style="color: #4f79a7;">Exachanger</span>
        </a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#nav" style="box-shadow: none;">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav ms-auto gap-1">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}" 
                       style="font-weight: 500; padding: 8px 18px; border-radius: 30px; transition: all 0.2s ease; color: #4a5568;">
                        Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('exchange.rate') ? 'active' : '' }}" href="{{ route('exchange.rate') }}"
                       style="font-weight: 500; padding: 8px 18px; border-radius: 30px; transition: all 0.2s ease; color: #4a5568;">
                        Exchange Rate
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('track.transaction') ? 'active' : '' }}" href="{{ route('track.transaction') }}"
                       style="font-weight: 500; padding: 8px 18px; border-radius: 30px; transition: all 0.2s ease; color: #4a5568;">
                        Tracking
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Breadcrumb untuk SEO (hanya tampil di halaman selain home) -->
@if(!request()->routeIs('home'))
<!-- <div class="container mt-2">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0" style="background: transparent; padding: 8px 0; margin: 0;">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: #4f79a7; text-decoration: none;">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">
                @if(request()->routeIs('exchange.rate'))
                    Exchange Rates
                @elseif(request()->routeIs('track.transaction'))
                    Track Transaction
                @else
                    {{ ucwords(str_replace(['-', '/'], [' ', ' / '], request()->path())) }}
                @endif
            </li>
        </ol>
    </nav>
</div> -->
@endif

<style>
    .nav-link:hover {
        background-color: #f0f2f5 !important;
        color: #0d6efd !important;
        transform: translateY(-1px);
    }
    
    .nav-link.active {
        background: #4f79a7 !important;  /* warna solid, bukan gradasi */
        color: white !important;
        box-shadow: 0 4px 10px rgba(79, 121, 167, 0.25);  /* optional: sesuaikan shadow */
    }
    
    .navbar-toggler:focus {
        box-shadow: none;
        outline: none;
    }
    
    @media (max-width: 991.98px) {
        .nav-link {
            text-align: center;
            margin: 5px 0;
        }
        .navbar-nav {
            padding-top: 10px;
        }
    }
</style>