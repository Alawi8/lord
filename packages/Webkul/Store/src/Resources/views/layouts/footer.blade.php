{{-- resources/themes/store/views/layouts/footer.blade.php --}}
<footer class="bg-dark text-light pt-5 pb-3">
    <div class="container">
        <div class="row g-4">
            {{-- Company Info --}}
            <div class="col-lg-4 col-md-6">
                <h5 class="fw-bold mb-3">{{ core()->getCurrentChannel()->name }}</h5>
                <p class="text-light opacity-75">
                    {{ core()->getCurrentChannel()->description ?? 'متجر إلكتروني يقدم أفضل المنتجات بأسعار تنافسية وجودة عالية.' }}
                </p>
                
                {{-- Social Media --}}
                <div class="d-flex gap-3 mt-3">
                    <a href="#" class="text-light opacity-75 fs-5">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="#" class="text-light opacity-75 fs-5">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="text-light opacity-75 fs-5">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="text-light opacity-75 fs-5">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a href="#" class="text-light opacity-75 fs-5">
                        <i class="fab fa-linkedin"></i>
                    </a>
                </div>
            </div>
            
            {{-- Quick Links --}}
            <div class="col-lg-2 col-md-6">
                <h6 class="fw-bold mb-3">روابط سريعة</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="{{ route('store.home.index') }}" class="text-light opacity-75 text-decoration-none">
                            الرئيسية
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('store.search.index') }}" class="text-light opacity-75 text-decoration-none">
                            جميع المنتجات
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-light opacity-75 text-decoration-none">
                            من نحن
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-light opacity-75 text-decoration-none">
                            اتصل بنا
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-light opacity-75 text-decoration-none">
                            الأسئلة الشائعة
                        </a>
                    </li>
                </ul>
            </div>
            
            {{-- Categories --}}
            <div class="col-lg-2 col-md-6">
                <h6 class="fw-bold mb-3">الفئات</h6>
                <ul class="list-unstyled">
                    @foreach(core()->getCurrentChannel()->root_category->children->where('status', 1)->take(5) as $category)
                        <li class="mb-2">
                            <a href="#" 
                               class="text-light opacity-75 text-decoration-none">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            
            {{-- Customer Service --}}
            <div class="col-lg-2 col-md-6">
                <h6 class="fw-bold mb-3">خدمة العملاء</h6>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <a href="#" class="text-light opacity-75 text-decoration-none">
                            سياسة الاستبدال
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-light opacity-75 text-decoration-none">
                            سياسة الشحن
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-light opacity-75 text-decoration-none">
                            سياسة الخصوصية
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="text-light opacity-75 text-decoration-none">
                            الشروط والأحكام
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('store.customers.account.orders.index') }}" 
                           class="text-light opacity-75 text-decoration-none">
                            تتبع الطلب
                        </a>
                    </li>
                </ul>
            </div>
            
            {{-- Contact Info --}}
            <div class="col-lg-2 col-md-6">
                <h6 class="fw-bold mb-3">معلومات التواصل</h6>
                <div class="text-light opacity-75">
                    <div class="mb-2">
                        <i class="fas fa-map-marker-alt me-2"></i>
                        <small>المملكة العربية السعودية</small>
                    </div>
                    <div class="mb-2">
                        <i class="fas fa-phone me-2"></i>
                        <small>+966 50 123 4567</small>
                    </div>
                    <div class="mb-2">
                        <i class="fas fa-envelope me-2"></i>
                        <small>info@store.com</small>
                    </div>
                    <div class="mb-2">
                        <i class="fas fa-clock me-2"></i>
                        <small>24/7 دعم العملاء</small>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Payment Methods --}}
        <div class="row mt-4 pt-4 border-top border-secondary">
            <div class="col-md-6">
                <h6 class="fw-bold mb-3">طرق الدفع المقبولة</h6>
                <div class="d-flex gap-3">
                    <img src="https://via.placeholder.com/50x30/0066cc/ffffff?text=VISA" 
                         alt="Visa" class="bg-white rounded p-1">
                    <img src="https://via.placeholder.com/50x30/cc0000/ffffff?text=MC" 
                         alt="Mastercard" class="bg-white rounded p-1">
                    <img src="https://via.placeholder.com/50x30/009900/ffffff?text=MADA" 
                         alt="Mada" class="bg-white rounded p-1">
                    <img src="https://via.placeholder.com/50x30/0099cc/ffffff?text=APPLE" 
                         alt="Apple Pay" class="bg-white rounded p-1">
                    <img src="https://via.placeholder.com/50x30/ff6600/ffffff?text=STC" 
                         alt="STC Pay" class="bg-white rounded p-1">
                </div>
            </div>
            
            <div class="col-md-6 text-md-end">
                <h6 class="fw-bold mb-3">تطبيق الجوال</h6>
                <div class="d-flex gap-2 justify-content-md-end">
                    <a href="#" class="text-decoration-none">
                        <img src="https://via.placeholder.com/120x40/000000/ffffff?text=App+Store" 
                             alt="Download on App Store" class="rounded">
                    </a>
                    <a href="#" class="text-decoration-none">
                        <img src="https://via.placeholder.com/120x40/000000/ffffff?text=Google+Play" 
                             alt="Get it on Google Play" class="rounded">
                    </a>
                </div>
            </div>
        </div>
        
        {{-- Copyright --}}
        <div class="row mt-4 pt-3 border-top border-secondary">
            <div class="col-md-6">
                <p class="text-light opacity-75 mb-0">
                    &copy; {{ date('Y') }} {{ core()->getCurrentChannel()->name }}. 
                    جميع الحقوق محفوظة.
                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="text-light opacity-75 mb-0">
                    تم التطوير بواسطة 
                    <a href="#" class="text-light text-decoration-none fw-bold">فريق التطوير</a>
                </p>
            </div>
        </div>
    </div>
</footer>

{{-- Back to Top Button --}}
<button class="btn btn-primary position-fixed bottom-0 end-0 m-4 rounded-circle" 
        id="backToTop" 
        style="width: 50px; height: 50px; z-index: 1050; display: none;">
    <i class="fas fa-arrow-up"></i>
</button>

<script>
// Back to Top functionality
window.addEventListener('scroll', function() {
    const backToTop = document.getElementById('backToTop');
    if (window.pageYOffset > 300) {
        backToTop.style.display = 'block';
    } else {
        backToTop.style.display = 'none';
    }
});

document.getElementById('backToTop').addEventListener('click', function() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});
</script>
