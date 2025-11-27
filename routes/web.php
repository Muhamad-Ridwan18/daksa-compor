<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\ContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\JobApplicationController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Frontend\AboutController;
use App\Http\Controllers\Frontend\CareerController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\ServiceController as FrontendServiceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

// SEO Routes
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots');

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');

// Blog Routes
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::post('/blog/{article}/comment', [BlogController::class, 'storeComment'])->name('blog.comment.store');

// Careers Routes (Frontend)
Route::get('/careers', [CareerController::class, 'index'])->name('careers.index');
Route::get('/careers/{slug}', [CareerController::class, 'show'])->name('careers.show');
Route::post('/careers/{job}/apply', [CareerController::class, 'apply'])->name('careers.apply');

// Gallery Routes (Frontend)
Route::get('/gallery', [App\Http\Controllers\Frontend\GalleryController::class, 'index'])->name('gallery.index');

// Service Routes (Frontend)
Route::get('/services/{service}', [FrontendServiceController::class, 'show'])->name('services.show');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'inactivity'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Services Management
    Route::resource('services', ServiceController::class);
    
    // Products Management
    Route::resource('products', ProductController::class);
    
    // Testimonials Management
    Route::resource('testimonials', TestimonialController::class);
    
    // Clients Management
    Route::resource('clients', ClientController::class);
    
    // Contact Messages Management
    Route::get('/contact-messages', [ContactMessageController::class, 'index'])->name('contact-messages.index');
    Route::get('/contact-messages/{contactMessage}', [ContactMessageController::class, 'show'])->name('contact-messages.show');
    Route::patch('/contact-messages/{contactMessage}/mark-read', [ContactMessageController::class, 'markAsRead'])->name('contact-messages.mark-read');
    Route::patch('/contact-messages/{contactMessage}/mark-unread', [ContactMessageController::class, 'markAsUnread'])->name('contact-messages.mark-unread');
    Route::delete('/contact-messages/{contactMessage}', [ContactMessageController::class, 'destroy'])->name('contact-messages.destroy');
    
    // Orders Management
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
    
    // Settings Management
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::patch('/settings', [SettingController::class, 'update'])->name('settings.update');
    Route::post('/settings/upload-image', [SettingController::class, 'uploadImage'])->name('settings.upload-image');
    
    // Articles Management
    Route::resource('articles', ArticleController::class);
    Route::post('/upload-image', [ArticleController::class, 'uploadImage'])->name('upload-image');
    
    // Comments Management
    Route::get('/comments', [CommentController::class, 'index'])->name('comments.index');
    Route::patch('/comments/{comment}/approve', [CommentController::class, 'approve'])->name('comments.approve');
    Route::patch('/comments/{comment}/unapprove', [CommentController::class, 'unapprove'])->name('comments.unapprove');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Team Members Management
    Route::resource('team-members', TeamMemberController::class)->parameters([
        'team-members' => 'team_member',
    ]);

    // Jobs Management
    Route::resource('jobs', JobController::class);
    // Job Applications Management
    Route::get('job-applications', [JobApplicationController::class, 'index'])->name('job-applications.index');
    Route::get('job-applications/{application}', [JobApplicationController::class, 'show'])->name('job-applications.show');
    Route::patch('job-applications/{application}/status', [JobApplicationController::class, 'updateStatus'])->name('job-applications.update-status');
    Route::get('job-applications/{application}/download-cv', [JobApplicationController::class, 'downloadCv'])->name('job-applications.download-cv');
    
    // Gallery Management
    Route::resource('galleries', GalleryController::class);
    
    // Users Management
    Route::resource('users', UserController::class);
});

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Dashboard redirect for authenticated users
    Route::get('/dashboard', function () {
        return redirect()->route('admin.dashboard');
    })->name('dashboard');
});

require __DIR__.'/auth.php';
