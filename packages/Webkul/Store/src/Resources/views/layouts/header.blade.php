{{-- resources/themes/store/views/layouts/header.blade.php --}}
<header class="store-header">
    <div class="container">
        <div class="row align-items-center py-3">
            {{-- Logo --}}
            <div class="col-md-4">
                <a href="{{ route('store.home.index') }}" class="navbar-brand text-decoration-none">
                    @if (core()->getCurrentChannel()->logo_url)
                        <img src="{{ core()->getCurrentChannel()->logo_url }}" 
                             alt="{{ core()->getCurrentChannel()->name }}" 
                             class="img-fluid" style="max-height: 50px;">
                    @else
                        <h3 class="text-white mb-0">{{ core()->getCurrentChannel()->name }}</h3>
                    @endif
                </a>
            </div>
            
            {{-- Search Bar --}}
            <div class="col-md-5">
                <form action="{{ route('store.search.index') }}" method="GET" class="d-flex">
                    <input type="text" 
                           name="query" 
                           class="form-control me-2" 
                           placeholder="البحث عن المنتجات..." 
                           value="{{ request('query') }}">
                    <button type="submit" class="btn btn-light">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
            
            {{-- User Actions --}}
            <div class="col-md-3 text-end">
                <div class="d-flex justify-content-end align-items-center gap-2">
                    {{-- Cart --}}
                    <a href="{{ route('store.checkout.cart.index') }}" 
                       class="btn btn-outline-light position-relative text-decoration-none">
                        <i class="fas fa-storeping-cart"></i>

                    </a>
                    
                    {{-- User Account --}}
                    @if(auth()->guard('customer')->check())
                        <div class="dropdown">
                            <button class="btn btn-outline-light dropdown-toggle" 
                                    type="button" 
                                    data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i>
                                {{ auth()->guard('customer')->user()->first_name ?? 'العضو' }}
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" 
                                       href="{{ route('store.customers.account.profile.index') }}">
                                        <i class="fas fa-user me-2"></i>حسابي
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" 
                                       href="{{ route('store.customers.account.orders.index') }}">
                                        <i class="fas fa-storeping-bag me-2"></i>طلباتي
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" 
                                       href="{{ route('store.customers.account.wishlist.index') }}">
                                        <i class="fas fa-heart me-2"></i>المفضلة
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('store.customer.session.destroy') }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i>تسجيل الخروج
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('store.customer.session.index') }}" 
                           class="btn btn-outline-light text-decoration-none">
                            <i class="fas fa-sign-in-alt"></i>
                            دخول
                        </a>
                    @endif
                </div>
            </div>
        </div>
        
        {{-- Quick Actions Row --}}
        <div class="row border-top border-white-50 pt-2 d-none d-md-block">
            <div class="col-12">
                <div class="d-flex justify-content-center gap-4">
                    <a href="{{ route('store.customers.account.wishlist.index') }}" 
                       class="text-white text-decoration-none small">
                        <i class="fas fa-heart me-1"></i>المفضلة
                    </a>
                    <a href="{{ route('store.compare.index') }}" 
                       class="text-white text-decoration-none small">
                        <i class="fas fa-balance-scale me-1"></i>المقارنة
                    </a>
                    <span class="text-white-50 small">
                        <i class="fas fa-phone me-1"></i>{{ core()->getCurrentChannel()->contact_number ?? '966501234567' }}
                    </span>
                    <span class="text-white-50 small">
                        <i class="fas fa-envelope me-1"></i>{{ core()->getCurrentChannel()->contact_email ?? 'info@store.com' }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</header>