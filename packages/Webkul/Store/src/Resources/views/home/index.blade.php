{{-- resources/themes/store/views/home/index.blade.php --}}
@extends('store::layouts.master')

@section('page_title')
    الرئيسية
@endsection

@section('meta_description')
    {{ core()->getCurrentChannel()->description }}
@endsection

@section('content')
    {{-- Hero Section --}}
    <section class="store-hero d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center text-white">
                    <h1 class="display-4 fw-bold mb-4">
                        مرحباً بك في متجر {{ core()->getCurrentChannel()->name }}
                    </h1>
                    <p class="lead mb-5">
                        اكتشف أفضل المنتجات بأسعار رائعة وجودة عالية
                    </p>
                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                        <a href="{{ route('store.search.index') }}" 
                           class="btn btn-light btn-lg px-5">
                            <i class="fas fa-storeping-bag me-2"></i>
                            تسوق الآن
                        </a>
                        <a href="#features" 
                           class="btn btn-outline-light btn-lg px-5">
                            <i class="fas fa-info-circle me-2"></i>
                            اعرف المزيد
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Features Section --}}
    <section class="py-5 bg-light" id="features">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <h2 class="display-5 fw-bold mb-3">لماذا نحن؟</h2>
                    <p class="lead text-muted">مميزات تجعلنا الأفضل</p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4 text-center">
                    <div class="p-4">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-shipping-fast fa-3x text-primary"></i>
                        </div>
                        <h5 class="fw-bold">توصيل سريع</h5>
                        <p class="text-muted">توصيل مجاني للطلبات أكثر من 200 ريال خلال 24 ساعة</p>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="p-4">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-shield-alt fa-3x text-success"></i>
                        </div>
                        <h5 class="fw-bold">دفع آمن</h5>
                        <p class="text-muted">طرق دفع متعددة وآمنة 100% مع ضمان الاسترداد</p>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="p-4">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-headset fa-3x text-info"></i>
                        </div>
                        <h5 class="fw-bold">دعم 24/7</h5>
                        <p class="text-muted">فريق دعم متخصص متاح على مدار الساعة</p>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="p-4">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-undo-alt fa-3x text-warning"></i>
                        </div>
                        <h5 class="fw-bold">استبدال مجاني</h5>
                        <p class="text-muted">إمكانية الاستبدال خلال 30 يوم بدون أي رسوم</p>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="p-4">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-star fa-3x text-danger"></i>
                        </div>
                        <h5 class="fw-bold">جودة عالية</h5>
                        <p class="text-muted">منتجات مضمونة الجودة من أفضل الماركات العالمية</p>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="p-4">
                        <div class="feature-icon mb-3">
                            <i class="fas fa-tags fa-3x text-purple"></i>
                        </div>
                        <h5 class="fw-bold">عروض حصرية</h5>
                        <p class="text-muted">خصومات وعروض حصرية لعملائنا المميزين</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Categories Preview Section --}}
    <section class="py-5" id="categories">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <h2 class="display-5 fw-bold mb-3">تصفح الأقسام</h2>
                    <p class="lead text-muted">اختر من مجموعة واسعة من الفئات</p>
                </div>
            </div>
            
            <div class="row g-4">
                {{-- Static Category Cards --}}
                <div class="col-md-4 col-lg-2">
                    <div class="card h-100 border-0 shadow-sm category-card">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-tshirt fa-3x text-primary mb-3"></i>
                            <h6 class="card-title">الملابس</h6>
                            <small class="text-muted">أزياء عصرية</small>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 col-lg-2">
                    <div class="card h-100 border-0 shadow-sm category-card">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-laptop fa-3x text-success mb-3"></i>
                            <h6 class="card-title">الإلكترونيات</h6>
                            <small class="text-muted">أحدث التقنيات</small>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 col-lg-2">
                    <div class="card h-100 border-0 shadow-sm category-card">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-home fa-3x text-info mb-3"></i>
                            <h6 class="card-title">المنزل</h6>
                            <small class="text-muted">ديكور وأثاث</small>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 col-lg-2">
                    <div class="card h-100 border-0 shadow-sm category-card">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-gamepad fa-3x text-warning mb-3"></i>
                            <h6 class="card-title">الألعاب</h6>
                            <small class="text-muted">ترفيه وتسلية</small>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 col-lg-2">
                    <div class="card h-100 border-0 shadow-sm category-card">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-dumbbell fa-3x text-danger mb-3"></i>
                            <h6 class="card-title">الرياضة</h6>
                            <small class="text-muted">لياقة وصحة</small>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 col-lg-2">
                    <div class="card h-100 border-0 shadow-sm category-card">
                        <div class="card-body text-center p-4">
                            <i class="fas fa-book fa-3x text-purple mb-3"></i>
                            <h6 class="card-title">الكتب</h6>
                            <small class="text-muted">ثقافة ومعرفة</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-5">
                <a href="{{ route('store.search.index') }}" class="btn btn-primary btn-lg px-5">
                    عرض جميع المنتجات
                    <i class="fas fa-arrow-left ms-2"></i>
                </a>
            </div>
        </div>
    </section>

    {{-- Stats Section --}}
    <section class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row g-4 text-center">
                <div class="col-md-3">
                    <div class="stat-item">
                        <h2 class="display-4 fw-bold mb-0">10K+</h2>
                        <p class="mb-0">منتج متاح</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <h2 class="display-4 fw-bold mb-0">50K+</h2>
                        <p class="mb-0">عميل سعيد</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <h2 class="display-4 fw-bold mb-0">99%</h2>
                        <p class="mb-0">رضا العملاء</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-item">
                        <h2 class="display-4 fw-bold mb-0">24/7</h2>
                        <p class="mb-0">خدمة العملاء</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Newsletter Section --}}
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h3 class="mb-3">اشترك في النشرة البريدية</h3>
                    <p class="mb-4 text-muted">احصل على آخر العروض والمنتجات الجديدة مباشرة في بريدك</p>
                    
                    <div class="row g-3 justify-content-center">
                        <div class="col-md-6">
                            <input type="email" 
                                   class="form-control form-control-lg" 
                                   placeholder="أدخل بريدك الإلكتروني">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                <i class="fas fa-paper-plane me-2"></i>
                                اشتراك
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Call to Action Section --}}
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card bg-gradient-primary text-white border-0 shadow-lg">
                        <div class="card-body p-5 text-center">
                            <h3 class="card-title mb-3">ابدأ رحلة التسوق الآن</h3>
                            <p class="card-text mb-4 fs-5">
                                اكتشف آلاف المنتجات الرائعة واحصل على أفضل العروض والخصومات الحصرية
                            </p>
                            
                            <div class="d-flex justify-content-center gap-3 flex-wrap">
                                <a href="{{ route('store.search.index') }}" 
                                   class="btn btn-light btn-lg px-4">
                                    <i class="fas fa-storeping-cart me-2"></i>
                                    ابدأ التسوق
                                </a>
                                @guest('customer')
                                    <a href="{{ route('store.customer.session.index') }}" 
                                       class="btn btn-outline-light btn-lg px-4">
                                        <i class="fas fa-user-plus me-2"></i>
                                        انضم إلينا
                                    </a>
                                @endguest
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('footer')
<style>
    .store-hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 500px;
    }
    
    .category-card:hover, .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
        transition: all 0.3s ease;
    }
    
    .feature-icon {
        transition: transform 0.3s ease;
    }
    
    .feature-icon:hover {
        transform: scale(1.1);
    }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    }
    
    .text-purple {
        color: #6f42c1 !important;
    }
    
    .stat-item h2 {
        color: rgba(255,255,255,0.9);
    }
    
    @media (max-width: 768px) {
        .display-4 {
            font-size: 2rem;
        }
        
        .display-5 {
            font-size: 1.8rem;
        }
    }
</style>
@endsection