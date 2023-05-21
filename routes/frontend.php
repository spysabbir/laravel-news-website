<?php

use App\Http\Controllers\Frontend\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Frontend\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Frontend\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Frontend\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Frontend\Auth\NewPasswordController;
use App\Http\Controllers\Frontend\Auth\PasswordResetLinkController;
use App\Http\Controllers\Frontend\Auth\RegisteredUserController;
use App\Http\Controllers\Frontend\Auth\VerifyEmailController;
use App\Http\Controllers\Frontend\UserController;
use App\Http\Controllers\Frontend\FrontendController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/google/login/', [UserController::class, 'redirectToGoogle'])->name('google.login');
    Route::get('/google/login/callback', [UserController::class, 'handleGoogleCallback']);

    Route::get('/facebook/login/', [UserController::class, 'redirectToFacebook'])->name('facebook.login');
    Route::get('/facebook/login/callback', [UserController::class, 'handleFacebookCallback']);

    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.update');

});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])->name('verification.verify')
                ->middleware(['signed', 'throttle:6,1']);
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->name('verification.send')
                ->middleware('throttle:6,1');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])->name('password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::middleware(['verified'])->group(function(){
        Route::get('dashboard', [UserController::class, 'dashboard'])->name('dashboard');
        Route::post('profile-update', [UserController::class, 'profileUpdate'])->name('profile.update');
        Route::post('password-update', [UserController::class, 'passwordUpdate'])->name('password.update');
    });
});

    Route::get('/', [FrontendController::class, 'index'])->name('index');
    Route::get('change/language', [FrontendController::class, 'changeLanguage'])->name('change.language');


    Route::get('/all-news', [FrontendController::class, 'allNews'])->name('all.news');
    Route::get('/all-category', [FrontendController::class, 'allCategory'])->name('all.category');
    Route::get('/all-tag', [FrontendController::class, 'allTag'])->name('all.tag');
    Route::get('/category-wise-news/{slug}', [FrontendController::class, 'categoryWiseNews'])->name('category.wise.news');
    Route::get('/tag-wise-news/{slug}', [FrontendController::class, 'tagWiseNews'])->name('tag.wise.news');
    Route::get('/reporter-wise-news/{id}', [FrontendController::class, 'reporterWiseNews'])->name('reporter.wise.news');
    Route::get('location-wise-news', [FrontendController::class, 'locationWiseNews'])->name('location.wise.news');
    Route::get('/news-details/{slug}', [FrontendController::class, 'newsDetails'])->name('news.details');
    Route::post('/comment-store', [FrontendController::class, 'commentStore'])->name('comment.store');
    Route::post('/comment-reply/store', [FrontendController::class, 'commentReplyStore'])->name('comment.reply.store');

    Route::get('/page/{slug}', [FrontendController::class, 'page'])->name('page');

    Route::get('/all-gallery-photo', [FrontendController::class, 'allGalleryPhoto'])->name('all.gallery.photo');
    Route::get('/all-gallery-video', [FrontendController::class, 'allGalleryVideo'])->name('all.gallery.video');

    Route::get('/about-us', [FrontendController::class, 'aboutUs'])->name('about.us');

    Route::get('/contact-us', [FrontendController::class, 'contactUs'])->name('contact.us');
    Route::post('/contact-message-store', [FrontendController::class, 'contactMessageStore'])->name('contact.message.store');

    Route::get('/today-news', [FrontendController::class, 'todayNews'])->name('today.news');
    Route::get('/archive-news-result', [FrontendController::class, 'archiveNewsResult'])->name('archive.news.result');

    Route::post('/subscriber-store', [FrontendController::class, 'subscriberStore'])->name('subscriber.store');

    Route::post('/find-news', [FrontendController::class, 'findNews'])->name('find.news');
    Route::get('/search-news', [FrontendController::class, 'searchNews'])->name('search.news');

    Route::post('get-divisions', [FrontendController::class, 'getDivisions'])->name('get.divisions');
    Route::post('get-districts', [FrontendController::class, 'getDistricts'])->name('get.districts');
    Route::post('get-upazilas', [FrontendController::class, 'getUpazilas'])->name('get.upazilas');
    Route::post('get-unions', [FrontendController::class, 'getUnions'])->name('get.unions');

