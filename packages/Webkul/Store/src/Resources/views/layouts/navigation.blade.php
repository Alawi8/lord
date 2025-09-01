{{-- resources/themes/store/views/layouts/navigation.blade.php --}}
<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
    <div class="container">
        {{-- Mobile Toggle Button --}}
        <button class="navbar-toggler" 
                type="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        {{-- Navigation Menu --}}
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                {{-- Home --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('store.home.index') ? 'active' : '' }}" 
                       href="{{ route('store.home.index') }}">
                        <i class="fas fa-home"></i>
                        الرئيسية
                    </a>
                </li>
                
                {{-- Categories --}}
                @if(core()->getCurrentChannel()->root_category && core()->getCurrentChannel()->root_category->children)
                    @foreach (core()->getCurrentChannel()->root_category->children->where('status', 1)->take(5) as $category)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" 
                               href="#"
                               data-bs-toggle="dropdown">
                                {{ $category->name }}
                            </a>
                            
                            {{-- Sub Categories --}}
                            @if ($category->children && $category->children->where('status', 1)->count())
                                <ul class="dropdown-menu">
                                    @foreach ($category->children->where('status', 1)->take(6) as $subCategory)
                                        <li>
                                            <a class="dropdown-item" 
                                               href="#">
                                                {{ $subCategory->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                @else
                    {{-- Static Categories as fallback --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" 
                           href="{{ route('store.search.index') }}"
                           data-bs-toggle="dropdown">
                            الفئات
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('store.search.index') }}">جميع المنتجات</a></li>
                            <li><a class="dropdown-item" href="{{ route('store.search.index') }}?category=electronics">الإلكترونيات</a></li>
                            <li><a class="dropdown-item" href="{{ route('store.search.index') }}?category=fashion">الأزياء</a></li>
                            <li><a class="dropdown-item" href="{{ route('store.search.index') }}?category=home">المنزل</a></li>
                        </ul>
                    </li>
                @endif
                
                {{-- Products --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('store.search.index') }}">
                        <i class="fas fa-box"></i>
                        جميع المنتجات
                    </a>
                </li>
                
                {{-- Special Offers --}}
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('store.search.index') }}?special=1">
                        <i class="fas fa-fire"></i>
                        العروض الخاصة
                    </a>
                </li>
                
                {{-- Contact --}}
                @if(Route::has('store.home.contact_us'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('store.home.contact_us') }}">
                            <i class="fas fa-phone"></i>
                            اتصل بنا
                        </a>
                    </li>
                @endif
            </ul>
            
            {{-- Quick Links --}}
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('store.customers.account.wishlist.index') }}">
                        <i class="fas fa-heart"></i>
                        المفضلة
                        @if(auth('customer')->check() && auth('customer')->user()->wishlist_items)
                            <span class="badge bg-danger ms-1">
                                {{ auth('customer')->user()->wishlist_items->count() }}
                            </span>
                        @else
                            <span class="badge bg-secondary ms-1">0</span>
                        @endif
                    </a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('store.compare.index') }}">
                        <i class="fas fa-balance-scale"></i>
                        المقارنة
                        <span class="badge bg-info ms-1">
                            {{ count(session('compare', [])) }}
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

{{-- Breadcrumb --}}
@if (!request()->routeIs('store.home.index'))
    <nav aria-label="breadcrumb" class="bg-light py-2">
        <div class="container">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('store.home.index') }}">الرئيسية</a>
                </li>
                @yield('breadcrumbs')
            </ol>
        </div>
    </nav>
@endif