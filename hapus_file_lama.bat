@echo off
chcp 65001 >nul
cd /d "%~dp0"

echo ==========================================================
echo   HAPUS FILE LAMA WEBSITE VESCA (halaman admin tak terpakai)
echo ==========================================================
echo.
if not exist artisan (
    echo [BERHENTI] File ini harus ada di folder utama project ^(sejajar dengan file "artisan"^).
    pause
    exit /b 1
)
echo File yang dihapus: halaman backend lama, kategori dan produk admin, pesanan,
echo klaim garansi, pelacakan, teknisi, role, dll, beserta halaman register,
echo profil bawaan, dan CSS-nya. DATABASE TIDAK DISENTUH.
echo.
echo Pastikan sudah ada BACKUP project. Proses ini tidak bisa dibatalkan.
echo.
set /p JAWAB=Ketik YA lalu tekan Enter untuk melanjutkan: 
if /i not "%JAWAB%"=="YA" (
    echo Dibatalkan. Tidak ada yang dihapus.
    pause
    exit /b 0
)
echo.
if exist "app\Http\Controllers\ChatAIController.php" ( del /f /q "app\Http\Controllers\ChatAIController.php" & echo dihapus: app\Http\Controllers\ChatAIController.php )
if exist "app\Http\Controllers\ChatbotController.php" ( del /f /q "app\Http\Controllers\ChatbotController.php" & echo dihapus: app\Http\Controllers\ChatbotController.php )
if exist "app\Http\Controllers\KategoriProdukController.php" ( del /f /q "app\Http\Controllers\KategoriProdukController.php" & echo dihapus: app\Http\Controllers\KategoriProdukController.php )
if exist "app\Http\Controllers\PermissionController.php" ( del /f /q "app\Http\Controllers\PermissionController.php" & echo dihapus: app\Http\Controllers\PermissionController.php )
if exist "app\Http\Controllers\ProfileController.php" ( del /f /q "app\Http\Controllers\ProfileController.php" & echo dihapus: app\Http\Controllers\ProfileController.php )
if exist "app\Http\Controllers\RoleController.php" ( del /f /q "app\Http\Controllers\RoleController.php" & echo dihapus: app\Http\Controllers\RoleController.php )
if exist "app\Http\Controllers\Admin\ActivityLogController.php" ( del /f /q "app\Http\Controllers\Admin\ActivityLogController.php" & echo dihapus: app\Http\Controllers\Admin\ActivityLogController.php )
if exist "app\Http\Controllers\Admin\AdminKlaimGaransiController.php" ( del /f /q "app\Http\Controllers\Admin\AdminKlaimGaransiController.php" & echo dihapus: app\Http\Controllers\Admin\AdminKlaimGaransiController.php )
if exist "app\Http\Controllers\Admin\CustomerController.php" ( del /f /q "app\Http\Controllers\Admin\CustomerController.php" & echo dihapus: app\Http\Controllers\Admin\CustomerController.php )
if exist "app\Http\Controllers\Admin\DetailPesananController.php" ( del /f /q "app\Http\Controllers\Admin\DetailPesananController.php" & echo dihapus: app\Http\Controllers\Admin\DetailPesananController.php )
if exist "app\Http\Controllers\Admin\KapalController.php" ( del /f /q "app\Http\Controllers\Admin\KapalController.php" & echo dihapus: app\Http\Controllers\Admin\KapalController.php )
if exist "app\Http\Controllers\Admin\PembayaranController.php" ( del /f /q "app\Http\Controllers\Admin\PembayaranController.php" & echo dihapus: app\Http\Controllers\Admin\PembayaranController.php )
if exist "app\Http\Controllers\Admin\PesananController.php" ( del /f /q "app\Http\Controllers\Admin\PesananController.php" & echo dihapus: app\Http\Controllers\Admin\PesananController.php )
if exist "app\Http\Controllers\Admin\SerialProdukController.php" ( del /f /q "app\Http\Controllers\Admin\SerialProdukController.php" & echo dihapus: app\Http\Controllers\Admin\SerialProdukController.php )
if exist "app\Http\Controllers\Admin\TeknisiController.php" ( del /f /q "app\Http\Controllers\Admin\TeknisiController.php" & echo dihapus: app\Http\Controllers\Admin\TeknisiController.php )
if exist "app\Http\Controllers\Admin\TiketTeknisiController.php" ( del /f /q "app\Http\Controllers\Admin\TiketTeknisiController.php" & echo dihapus: app\Http\Controllers\Admin\TiketTeknisiController.php )
if exist "app\Http\Controllers\Admin\TrackingPesananController.php" ( del /f /q "app\Http\Controllers\Admin\TrackingPesananController.php" & echo dihapus: app\Http\Controllers\Admin\TrackingPesananController.php )
if exist "app\Http\Controllers\Admin\VerifikasiGaransiController.php" ( del /f /q "app\Http\Controllers\Admin\VerifikasiGaransiController.php" & echo dihapus: app\Http\Controllers\Admin\VerifikasiGaransiController.php )
if exist "app\Http\Controllers\Frontend\KlaimGaransiController.php" ( del /f /q "app\Http\Controllers\Frontend\KlaimGaransiController.php" & echo dihapus: app\Http\Controllers\Frontend\KlaimGaransiController.php )
if exist "app\Http\Controllers\Frontend\LacakPesananController.php" ( del /f /q "app\Http\Controllers\Frontend\LacakPesananController.php" & echo dihapus: app\Http\Controllers\Frontend\LacakPesananController.php )
if exist "app\Http\Controllers\Auth\ConfirmablePasswordController.php" ( del /f /q "app\Http\Controllers\Auth\ConfirmablePasswordController.php" & echo dihapus: app\Http\Controllers\Auth\ConfirmablePasswordController.php )
if exist "app\Http\Controllers\Auth\EmailVerificationNotificationController.php" ( del /f /q "app\Http\Controllers\Auth\EmailVerificationNotificationController.php" & echo dihapus: app\Http\Controllers\Auth\EmailVerificationNotificationController.php )
if exist "app\Http\Controllers\Auth\EmailVerificationPromptController.php" ( del /f /q "app\Http\Controllers\Auth\EmailVerificationPromptController.php" & echo dihapus: app\Http\Controllers\Auth\EmailVerificationPromptController.php )
if exist "app\Http\Controllers\Auth\NewPasswordController.php" ( del /f /q "app\Http\Controllers\Auth\NewPasswordController.php" & echo dihapus: app\Http\Controllers\Auth\NewPasswordController.php )
if exist "app\Http\Controllers\Auth\PasswordResetLinkController.php" ( del /f /q "app\Http\Controllers\Auth\PasswordResetLinkController.php" & echo dihapus: app\Http\Controllers\Auth\PasswordResetLinkController.php )
if exist "app\Http\Controllers\Auth\RegisteredUserController.php" ( del /f /q "app\Http\Controllers\Auth\RegisteredUserController.php" & echo dihapus: app\Http\Controllers\Auth\RegisteredUserController.php )
if exist "app\Http\Controllers\Auth\VerifyEmailController.php" ( del /f /q "app\Http\Controllers\Auth\VerifyEmailController.php" & echo dihapus: app\Http\Controllers\Auth\VerifyEmailController.php )
if exist "app\Http\Requests\ProfileUpdateRequest.php" ( del /f /q "app\Http\Requests\ProfileUpdateRequest.php" & echo dihapus: app\Http\Requests\ProfileUpdateRequest.php )
if exist "app\Models\Customer.php" ( del /f /q "app\Models\Customer.php" & echo dihapus: app\Models\Customer.php )
if exist "app\Models\DetailPesanan.php" ( del /f /q "app\Models\DetailPesanan.php" & echo dihapus: app\Models\DetailPesanan.php )
if exist "app\Models\Kapal.php" ( del /f /q "app\Models\Kapal.php" & echo dihapus: app\Models\Kapal.php )
if exist "app\Models\KategoriProduk.php" ( del /f /q "app\Models\KategoriProduk.php" & echo dihapus: app\Models\KategoriProduk.php )
if exist "app\Models\KlaimGaransi.php" ( del /f /q "app\Models\KlaimGaransi.php" & echo dihapus: app\Models\KlaimGaransi.php )
if exist "app\Models\Pembayaran.php" ( del /f /q "app\Models\Pembayaran.php" & echo dihapus: app\Models\Pembayaran.php )
if exist "app\Models\Pesanan.php" ( del /f /q "app\Models\Pesanan.php" & echo dihapus: app\Models\Pesanan.php )
if exist "app\Models\Produk.php" ( del /f /q "app\Models\Produk.php" & echo dihapus: app\Models\Produk.php )
if exist "app\Models\SerialProduk.php" ( del /f /q "app\Models\SerialProduk.php" & echo dihapus: app\Models\SerialProduk.php )
if exist "app\Models\StatusTracking.php" ( del /f /q "app\Models\StatusTracking.php" & echo dihapus: app\Models\StatusTracking.php )
if exist "app\Models\Teknisi.php" ( del /f /q "app\Models\Teknisi.php" & echo dihapus: app\Models\Teknisi.php )
if exist "app\Models\TiketTeknisi.php" ( del /f /q "app\Models\TiketTeknisi.php" & echo dihapus: app\Models\TiketTeknisi.php )
if exist "app\Models\TrackingPesanan.php" ( del /f /q "app\Models\TrackingPesanan.php" & echo dihapus: app\Models\TrackingPesanan.php )
if exist "app\Models\UploadFoto.php" ( del /f /q "app\Models\UploadFoto.php" & echo dihapus: app\Models\UploadFoto.php )
if exist "app\Models\VerifikasiGaransi.php" ( del /f /q "app\Models\VerifikasiGaransi.php" & echo dihapus: app\Models\VerifikasiGaransi.php )
if exist "app\Observers\ProdukObserver.php" ( del /f /q "app\Observers\ProdukObserver.php" & echo dihapus: app\Observers\ProdukObserver.php )
if exist "app\View\Components\AppLayout.php" ( del /f /q "app\View\Components\AppLayout.php" & echo dihapus: app\View\Components\AppLayout.php )
if exist "app\View\Components\GuestLayout.php" ( del /f /q "app\View\Components\GuestLayout.php" & echo dihapus: app\View\Components\GuestLayout.php )
if exist "resources\views\backend\activity-log" ( rmdir /s /q "resources\views\backend\activity-log" & echo dihapus: resources\views\backend\activity-log )
if exist "resources\views\backend\customer" ( rmdir /s /q "resources\views\backend\customer" & echo dihapus: resources\views\backend\customer )
if exist "resources\views\backend\detail-pesanan" ( rmdir /s /q "resources\views\backend\detail-pesanan" & echo dihapus: resources\views\backend\detail-pesanan )
if exist "resources\views\backend\kapal" ( rmdir /s /q "resources\views\backend\kapal" & echo dihapus: resources\views\backend\kapal )
if exist "resources\views\backend\kategori" ( rmdir /s /q "resources\views\backend\kategori" & echo dihapus: resources\views\backend\kategori )
if exist "resources\views\backend\klaim-garansi" ( rmdir /s /q "resources\views\backend\klaim-garansi" & echo dihapus: resources\views\backend\klaim-garansi )
if exist "resources\views\backend\pembayaran" ( rmdir /s /q "resources\views\backend\pembayaran" & echo dihapus: resources\views\backend\pembayaran )
if exist "resources\views\backend\permissions" ( rmdir /s /q "resources\views\backend\permissions" & echo dihapus: resources\views\backend\permissions )
if exist "resources\views\backend\pesanan" ( rmdir /s /q "resources\views\backend\pesanan" & echo dihapus: resources\views\backend\pesanan )
if exist "resources\views\backend\produk" ( rmdir /s /q "resources\views\backend\produk" & echo dihapus: resources\views\backend\produk )
if exist "resources\views\backend\roles" ( rmdir /s /q "resources\views\backend\roles" & echo dihapus: resources\views\backend\roles )
if exist "resources\views\backend\serial" ( rmdir /s /q "resources\views\backend\serial" & echo dihapus: resources\views\backend\serial )
if exist "resources\views\backend\teknisi" ( rmdir /s /q "resources\views\backend\teknisi" & echo dihapus: resources\views\backend\teknisi )
if exist "resources\views\backend\tiket-teknisi" ( rmdir /s /q "resources\views\backend\tiket-teknisi" & echo dihapus: resources\views\backend\tiket-teknisi )
if exist "resources\views\backend\tracking" ( rmdir /s /q "resources\views\backend\tracking" & echo dihapus: resources\views\backend\tracking )
if exist "resources\views\backend\verifikasi-garansi" ( rmdir /s /q "resources\views\backend\verifikasi-garansi" & echo dihapus: resources\views\backend\verifikasi-garansi )
if exist "resources\views\auth\confirm-password.blade.php" ( del /f /q "resources\views\auth\confirm-password.blade.php" & echo dihapus: resources\views\auth\confirm-password.blade.php )
if exist "resources\views\auth\forgot-password.blade.php" ( del /f /q "resources\views\auth\forgot-password.blade.php" & echo dihapus: resources\views\auth\forgot-password.blade.php )
if exist "resources\views\auth\register.blade.php" ( del /f /q "resources\views\auth\register.blade.php" & echo dihapus: resources\views\auth\register.blade.php )
if exist "resources\views\auth\reset-password.blade.php" ( del /f /q "resources\views\auth\reset-password.blade.php" & echo dihapus: resources\views\auth\reset-password.blade.php )
if exist "resources\views\auth\verify-email.blade.php" ( del /f /q "resources\views\auth\verify-email.blade.php" & echo dihapus: resources\views\auth\verify-email.blade.php )
if exist "resources\views\frontend\klaim" ( rmdir /s /q "resources\views\frontend\klaim" & echo dihapus: resources\views\frontend\klaim )
if exist "resources\views\frontend\lacak" ( rmdir /s /q "resources\views\frontend\lacak" & echo dihapus: resources\views\frontend\lacak )
if exist "resources\views\frontend\pesanan" ( rmdir /s /q "resources\views\frontend\pesanan" & echo dihapus: resources\views\frontend\pesanan )
if exist "resources\views\components" ( rmdir /s /q "resources\views\components" & echo dihapus: resources\views\components )
if exist "resources\views\dashboard.blade.php" ( del /f /q "resources\views\dashboard.blade.php" & echo dihapus: resources\views\dashboard.blade.php )
if exist "resources\views\welcome.blade.php" ( del /f /q "resources\views\welcome.blade.php" & echo dihapus: resources\views\welcome.blade.php )
if exist "resources\views\layouts\app.blade.php" ( del /f /q "resources\views\layouts\app.blade.php" & echo dihapus: resources\views\layouts\app.blade.php )
if exist "resources\views\layouts\guest.blade.php" ( del /f /q "resources\views\layouts\guest.blade.php" & echo dihapus: resources\views\layouts\guest.blade.php )
if exist "resources\views\layouts\navigation.blade.php" ( del /f /q "resources\views\layouts\navigation.blade.php" & echo dihapus: resources\views\layouts\navigation.blade.php )
if exist "resources\views\profile" ( rmdir /s /q "resources\views\profile" & echo dihapus: resources\views\profile )
if exist "tests\Feature\Auth\EmailVerificationTest.php" ( del /f /q "tests\Feature\Auth\EmailVerificationTest.php" & echo dihapus: tests\Feature\Auth\EmailVerificationTest.php )
if exist "tests\Feature\Auth\PasswordConfirmationTest.php" ( del /f /q "tests\Feature\Auth\PasswordConfirmationTest.php" & echo dihapus: tests\Feature\Auth\PasswordConfirmationTest.php )
if exist "tests\Feature\Auth\PasswordResetTest.php" ( del /f /q "tests\Feature\Auth\PasswordResetTest.php" & echo dihapus: tests\Feature\Auth\PasswordResetTest.php )
if exist "tests\Feature\Auth\RegistrationTest.php" ( del /f /q "tests\Feature\Auth\RegistrationTest.php" & echo dihapus: tests\Feature\Auth\RegistrationTest.php )
if exist "tests\Feature\ProfileTest.php" ( del /f /q "tests\Feature\ProfileTest.php" & echo dihapus: tests\Feature\ProfileTest.php )
if exist "public\css\activity-log.css" ( del /f /q "public\css\activity-log.css" & echo dihapus: public\css\activity-log.css )
if exist "public\css\admin_produk.css" ( del /f /q "public\css\admin_produk.css" & echo dihapus: public\css\admin_produk.css )
if exist "public\css\customer.css" ( del /f /q "public\css\customer.css" & echo dihapus: public\css\customer.css )
if exist "public\css\detail-pesanan.css" ( del /f /q "public\css\detail-pesanan.css" & echo dihapus: public\css\detail-pesanan.css )
if exist "public\css\detail_garansi.css" ( del /f /q "public\css\detail_garansi.css" & echo dihapus: public\css\detail_garansi.css )
if exist "public\css\form_klaim.css" ( del /f /q "public\css\form_klaim.css" & echo dihapus: public\css\form_klaim.css )
if exist "public\css\frontend.cssss" ( del /f /q "public\css\frontend.cssss" & echo dihapus: public\css\frontend.cssss )
if exist "public\css\garansi.css" ( del /f /q "public\css\garansi.css" & echo dihapus: public\css\garansi.css )
if exist "public\css\hasil_garansi.css" ( del /f /q "public\css\hasil_garansi.css" & echo dihapus: public\css\hasil_garansi.css )
if exist "public\css\kategori-produk.css" ( del /f /q "public\css\kategori-produk.css" & echo dihapus: public\css\kategori-produk.css )
if exist "public\css\klaim-garansi.css" ( del /f /q "public\css\klaim-garansi.css" & echo dihapus: public\css\klaim-garansi.css )
if exist "public\css\lacak-pesanan.css" ( del /f /q "public\css\lacak-pesanan.css" & echo dihapus: public\css\lacak-pesanan.css )
if exist "public\css\pembayaran.css" ( del /f /q "public\css\pembayaran.css" & echo dihapus: public\css\pembayaran.css )
if exist "public\css\pesanan.css" ( del /f /q "public\css\pesanan.css" & echo dihapus: public\css\pesanan.css )
if exist "public\css\produk_cus.css" ( del /f /q "public\css\produk_cus.css" & echo dihapus: public\css\produk_cus.css )
if exist "public\css\role-user.css" ( del /f /q "public\css\role-user.css" & echo dihapus: public\css\role-user.css )
if exist "public\css\serial-produk.css" ( del /f /q "public\css\serial-produk.css" & echo dihapus: public\css\serial-produk.css )
if exist "public\css\step2_garansi.css" ( del /f /q "public\css\step2_garansi.css" & echo dihapus: public\css\step2_garansi.css )
if exist "public\css\teknisi.css" ( del /f /q "public\css\teknisi.css" & echo dihapus: public\css\teknisi.css )
if exist "public\css\tiket_garansi.css" ( del /f /q "public\css\tiket_garansi.css" & echo dihapus: public\css\tiket_garansi.css )
if exist "public\css\tracking-pesanan.css" ( del /f /q "public\css\tracking-pesanan.css" & echo dihapus: public\css\tracking-pesanan.css )
if exist "public\css\tracking-show.css" ( del /f /q "public\css\tracking-show.css" & echo dihapus: public\css\tracking-show.css )
if exist "public\css\tracking.css" ( del /f /q "public\css\tracking.css" & echo dihapus: public\css\tracking.css )
if exist "public\css\verifikasi-garansi.css" ( del /f /q "public\css\verifikasi-garansi.css" & echo dihapus: public\css\verifikasi-garansi.css )
rmdir "app\Observers" 2>nul
rmdir "resources\views\components" 2>nul

echo.
echo ==========================================================
echo   SELESAI. Langkah berikutnya, jalankan satu per satu:
echo     composer dump-autoload
echo     php artisan optimize:clear
echo ==========================================================
pause
