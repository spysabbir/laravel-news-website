<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdvertisementController;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Admin\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Admin\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\Admin\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\Auth\VerifyEmailController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\Contact_messageController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\Page_settingController;
use App\Http\Controllers\Admin\Photo_galleryController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SubscriberController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\Video_galleryController;
use App\Http\Controllers\Admin\ReportController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function(){
    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
        Route::post('login', [AuthenticatedSessionController::class, 'store']);

        Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
        Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
        Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
        Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.update');
    });

    Route::middleware('admin_auth')->group(function () {
        Route::get('register', [RegisteredUserController::class, 'create'])->name('administrator.register');
        Route::post('register', [RegisteredUserController::class, 'store']);

        Route::get('verify-email', [EmailVerificationPromptController::class, '__invoke'])->name('verification.notice');
        Route::get('verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])->name('verification.verify')
                    ->middleware(['signed', 'throttle:6,1']);
        Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->name('verification.send')
                    ->middleware('throttle:6,1');

        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('profile', [AdminController::class, 'profile'])->name('profile');
        Route::post('profile-update', [AdminController::class, 'profileUpdate'])->name('profile.update');
        Route::post('password-update', [AdminController::class, 'passwordUpdate'])->name('password.update');

        Route::middleware(['super_admin'])->group(function () {

            Route::get('news-report', [ReportController::class, 'newsReport'])->name('news.report');

            Route::get('all-administrator', [AdminController::class, 'allAdministrator'])->name('all.administrator');
            Route::get('administrator-status/{id}', [AdminController::class, 'administratorStatus'])->name('administrator.status');
            Route::get('administrator-edit/{id}', [AdminController::class, 'administratoreEdit'])->name('administrator.edit');
            Route::patch('administrator-update/{id}', [AdminController::class, 'administratoreUpdate'])->name('administrator.update');

            Route::resource('page_setting', Page_settingController::class);
            Route::get('page_setting-status/{id}', [Page_settingController::class, 'status'])->name('page_setting.status');

            Route::get('about-us', [Page_settingController::class, 'aboutUs'])->name('about.us');
            Route::post('about-us-update-{id}', [Page_settingController::class, 'aboutUsUpdate'])->name('about.us.update');

            Route::get('default-setting', [SettingController::class, 'defaultSetting'])->name('default.setting');
            Route::post('default-setting-update-{id}', [SettingController::class, 'defaultSettingUpdate'])->name('default.setting.update');

            Route::get('mail-setting', [SettingController::class, 'mailSetting'])->name('mail.setting');
            Route::post('mail-setting-update-{id}', [SettingController::class, 'mailSettingUpdate'])->name('mail.setting.update');

            Route::get('seo-setting', [SettingController::class, 'seoSetting'])->name('seo.setting');
            Route::post('seo-setting-update-{id}', [SettingController::class, 'seoSettingUpdate'])->name('seo.setting.update');

            Route::get('social-login-setting', [SettingController::class, 'socialLoginSetting'])->name('social-login.setting');
            Route::post('social-login-setting-update-{id}', [SettingController::class, 'socialLoginSettingUpdate'])->name('social-login.setting.update');
        });

        Route::middleware(['admin'])->group(function () {
            Route::get('all-reporter', [AdminController::class, 'allReporter'])->name('all.reporter');
            Route::get('reporter-status/{id}', [AdminController::class, 'reporterStatus'])->name('reporter.status');
            Route::get('reporter-edit/{id}', [AdminController::class, 'reporterEdit'])->name('reporter.edit');
            Route::patch('reporter-update/{id}', [AdminController::class, 'reporterUpdate'])->name('reporter.update');

            Route::get('all-user', [AdminController::class, 'allUser'])->name('all.user');
            Route::get('user-status/{id}', [AdminController::class, 'userStatus'])->name('user.status');

            Route::get('all-contact-message', [Contact_messageController::class, 'allContactMessage'])->name('all.contact.message');
            Route::get('contact-message-view/{id}', [Contact_messageController::class, 'contactMessageView'])->name('contact.message.view');
            Route::get('contact-message-delete/{id}', [Contact_messageController::class, 'contactMessageDelete'])->name('contact.message.delete');

            Route::get('all-subscriber', [SubscriberController::class, 'allSubscriber'])->name('all.subscriber');
            Route::get('subscriber-delete/{id}', [SubscriberController::class, 'subscriberDelete'])->name('subscriber.delete');
            Route::get('subscriber-status/{id}', [SubscriberController::class, 'subscriberStatus'])->name('subscriber.status');
            Route::get('subscriber-export', [SubscriberController::class, 'subscriberExport'])->name('subscriber.export');
            Route::get('all-newsletter', [SubscriberController::class, 'allNewsletter'])->name('all.newsletter');
            Route::post('send-newsletter', [SubscriberController::class, 'sendNewsletter'])->name('send.newsletter');
            Route::get('view-newsletter/{id}', [SubscriberController::class, 'viewNewsletter'])->name('view.newsletter');

            Route::resource('advertisement', AdvertisementController::class);
            Route::get('advertisement-trashed', [AdvertisementController::class, 'trashed'])->name('advertisement.trashed');
            Route::get('advertisement-restore/{id}', [AdvertisementController::class, 'restore'])->name('advertisement.restore');
            Route::get('advertisement-forcedelete/{id}', [AdvertisementController::class, 'forceDelete'])->name('advertisement.forcedelete');
            Route::get('advertisement-status/{id}', [AdvertisementController::class, 'status'])->name('advertisement.status');

            Route::resource('branch', BranchController::class);
            Route::get('branch-trashed', [BranchController::class, 'trashed'])->name('branch.trashed');
            Route::get('branch-restore/{id}', [BranchController::class, 'restore'])->name('branch.restore');
            Route::get('branch-forcedelete/{id}', [BranchController::class, 'forceDelete'])->name('branch.forcedelete');
            Route::get('branch-status/{id}', [BranchController::class, 'status'])->name('branch.status');

            Route::resource('photo_gallery', Photo_galleryController::class);
            Route::get('photo_gallery-trashed', [Photo_galleryController::class, 'trashed'])->name('photo_gallery.trashed');
            Route::get('photo_gallery-restore/{id}', [Photo_galleryController::class, 'restore'])->name('photo_gallery.restore');
            Route::get('photo_gallery-forcedelete/{id}', [Photo_galleryController::class, 'forceDelete'])->name('photo_gallery.forcedelete');
            Route::get('photo_gallery-status/{id}', [Photo_galleryController::class, 'status'])->name('photo_gallery.status');

            Route::resource('video_gallery', Video_galleryController::class);
            Route::get('video_gallery-trashed', [Video_galleryController::class, 'trashed'])->name('video_gallery.trashed');
            Route::get('video_gallery-restore/{id}', [Video_galleryController::class, 'restore'])->name('video_gallery.restore');
            Route::get('video_gallery-forcedelete/{id}', [Video_galleryController::class, 'forceDelete'])->name('video_gallery.forcedelete');
            Route::get('video_gallery-status/{id}', [Video_galleryController::class, 'status'])->name('video_gallery.status');
        });

        Route::middleware(['reporter'])->group(function () {
            Route::resource('category', CategoryController::class);
            Route::get('category-trashed', [CategoryController::class, 'trashed'])->name('category.trashed');
            Route::get('category-restore/{id}', [CategoryController::class, 'restore'])->name('category.restore');
            Route::get('category-forcedelete/{id}', [CategoryController::class, 'forceDelete'])->name('category.forcedelete');
            Route::get('category-status/{id}', [CategoryController::class, 'status'])->name('category.status');
            Route::get('category-show-home-screen/{id}', [CategoryController::class, 'showHomeScreen'])->name('category.show.home.screen');

            Route::resource('tag', TagController::class);
            Route::get('tag-trashed', [TagController::class, 'trashed'])->name('tag.trashed');
            Route::get('tag-restore/{id}', [TagController::class, 'restore'])->name('tag.restore');
            Route::get('tag-forcedelete/{id}', [TagController::class, 'forceDelete'])->name('tag.forcedelete');
            Route::get('tag-status/{id}', [TagController::class, 'status'])->name('tag.status');

            Route::resource('news', NewsController::class);
            Route::get('news-trashed', [NewsController::class, 'trashed'])->name('news.trashed');
            Route::get('news-restore/{id}', [NewsController::class, 'restore'])->name('news.restore');
            Route::get('news-forcedelete/{id}', [NewsController::class, 'forceDelete'])->name('news.forcedelete');
            Route::get('news-status/{id}', [NewsController::class, 'status'])->name('news.status');
            Route::post('get/divisions', [NewsController::class, 'getDivisions'])->name('get.divisions');
            Route::post('get/districts', [NewsController::class, 'getDistricts'])->name('get.districts');
            Route::post('get/upazilas', [NewsController::class, 'getUpazilas'])->name('get.upazilas');
            Route::post('get/unions', [NewsController::class, 'getUnions'])->name('get.unions');

        });
    });
});
