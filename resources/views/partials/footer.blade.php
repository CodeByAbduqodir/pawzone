<footer class="py-5 mt-5">
    <div class="container-xl">
        <div class="row g-4 align-items-start">
            <div class="col-md-5">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <span class="brand-mark">🐾</span>
                    <div>
                        <h5 class="mb-0 text-white">PawZone</h5>
                        <div class="text-white-50 small">Uy hayvonlari uchun qulay platforma</div>
                    </div>
                </div>
                <p class="mb-0 text-white-50">
                    Yo'qolgan va topilgan hayvonlar bo'yicha e'lonlar, foydalanuvchi kabineti va admin boshqaruvi bir joyda.
                </p>
            </div>

            <div class="col-md-3">
                <h6 class="text-white mb-3">Tez havolalar</h6>
                <div class="d-grid gap-2 small">
                    <a href="{{ route('pets.index') }}">E'lonlar</a>
                    @auth
                        <a href="{{ route('dashboard') }}">Kabinet</a>
                        <a href="{{ route('pets.create') }}">Yangi e'lon</a>
                    @else
                        <a href="{{ route('login') }}">Kirish</a>
                        <a href="{{ route('register') }}">Ro'yxatdan o'tish</a>
                    @endauth
                </div>
            </div>

            <div class="col-md-4">
                <h6 class="text-white mb-3">Aloqa</h6>
                <div class="d-grid gap-2 small text-white-50">
                    <div>📍 Toshkent, O'zbekiston</div>
                    <div>📞 +998 90 123 45 67</div>
                    <div>✉️ info@pawzone.uz</div>
                </div>
            </div>
        </div>

        <hr class="my-4 border-secondary-subtle">

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2 small text-white-50">
            <span>&copy; {{ date('Y') }} PawZone. Barcha huquqlar himoyalangan.</span>
            <span>Made with care for lost and found pets.</span>
        </div>
    </div>
</footer>
