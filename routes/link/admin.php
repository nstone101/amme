<?php

Route::group(['middleware' => ['auth','admin', 'lang'], 'namespace' => 'Admin'], function() {
    Route::get('/', 'AdminController@adminDashboard')->name('adminDashboard');
    Route::get('/search', 'AdminController@qsSearch')->name('qsSearch');
    Route::get('contact-list', 'AdminController@contactList')->name('contactList');
    Route::get('contact-{id}', 'AdminController@contactDetails')->name('contactDetails');
    Route::get('subscriber-list', 'AdminController@subscriberList')->name('subscriberList');

    //profile setting
    Route::get('/profile','ProfileController@userProfile')->name('userProfile');
    Route::get('/password-change','ProfileController@passwordChange')->name('passwordChange');
    Route::post('/update-profile','ProfileController@updateProfile')->name('updateProfile');
    Route::post('/change-password','ProfileController@changePassword')->name('changePassword');

    // Setting
    Route::get('general-setting', 'SettingController@adminSettings')->name('adminSettings');
    Route::get('website-settings', 'SettingController@webSettings')->name('webSettings');
    Route::get('about-us', 'SettingController@aboutSettings')->name('aboutSettings');
    Route::post('about-us-setting-save', 'SettingController@adminAboutSettingsSave')->name('adminAboutSettingsSave');
    Route::post('save-setting', 'SettingController@saveSettings')->name('saveSettings');
    Route::post('save-image-setting', 'SettingController@adminImageUploadSave')->name('adminImageUploadSave');
    Route::post('save-web-setting', 'SettingController@saveWebSettings')->name('saveWebSettings');
    Route::post('save-achievement-setting', 'SettingController@saveAchievementSettings')->name('saveAchievementSettings');

    //User Management
    Route::get('user-list', 'UserController@userList')->name('userList');
    Route::get('add-user', 'UserController@addUser')->name('addUser');
    Route::get('user-details/{id}', 'UserController@userDetails')->name('userDetails');
    Route::get('user-edit/{id}', 'UserController@editUser')->name('editUser');
    Route::get('user-delete/{id}', 'UserController@userDelete')->name('userDelete');
    Route::get('user-active/{id}', 'UserController@userActivate')->name('userActivate');
    Route::get('verify-user-email/{id}', 'UserController@userEmailVerify')->name('userEmailVerify');
    Route::post('user-add-process', 'UserController@userAddProcess')->name('userAddProcess');
    Route::post('user-update-process', 'UserController@userUpdateProcess')->name('userUpdateProcess');

    //Team Category
    Route::get('team-category-list', 'TeamController@teamCategoryList')->name('teamCategoryList');
    Route::get('team-category-create', 'TeamController@teamCategoryCreate')->name('teamCategoryCreate');
    Route::post('team-category-save', 'TeamController@teamCategorySave')->name('teamCategorySave');
    Route::get('team-category-edit/{id}', 'TeamController@teamCategoryEdit')->name('teamCategoryEdit');
    Route::get('team-category-delete/{id}', 'TeamController@teamCategoryDelete')->name('teamCategoryDelete');

    //Team
    Route::get('team-list', 'TeamController@teamList')->name('teamList');
    Route::get('team-create', 'TeamController@teamCreate')->name('teamCreate');
    Route::post('team-save', 'TeamController@teamSave')->name('teamSave');
    Route::get('team-edit/{id}', 'TeamController@teamEdit')->name('teamEdit');
    Route::get('team-delete/{id}', 'TeamController@teamDelete')->name('teamDelete');

    // Service
    Route::get('service-list', 'ServiceController@serviceList')->name('serviceList');
    Route::get('service-create', 'ServiceController@serviceCreate')->name('serviceCreate');
    Route::post('service-save', 'ServiceController@serviceSave')->name('serviceSave');
    Route::get('service-edit/{id}', 'ServiceController@serviceEdit')->name('serviceEdit');
    Route::get('service-delete/{id}', 'ServiceController@serviceDelete')->name('serviceDelete');

    // testimonial
    Route::get('testimonial-list', 'TestimonialController@testimonialList')->name('testimonialList');
    Route::get('testimonial-create', 'TestimonialController@testimonialCreate')->name('testimonialCreate');
    Route::post('testimonial-save', 'TestimonialController@testimonialSave')->name('testimonialSave');
    Route::get('testimonial-edit/{id}', 'TestimonialController@testimonialEdit')->name('testimonialEdit');
    Route::get('testimonial-delete/{id}', 'TestimonialController@testimonialDelete')->name('testimonialDelete');

    // Portfolio Category
    Route::get('portfolio-category-list', 'PortfolioController@portfolioCategoryList')->name('portfolioCategoryList');
    Route::get('portfolio-category-create', 'PortfolioController@portfolioCategoryCreate')->name('portfolioCategoryCreate');
    Route::post('portfolio-category-save', 'PortfolioController@portfolioCategorySave')->name('portfolioCategorySave');
    Route::get('portfolio-category-edit/{id}', 'PortfolioController@portfolioCategoryEdit')->name('portfolioCategoryEdit');
    Route::get('portfolio-category-delete/{id}', 'PortfolioController@portfolioCategoryDelete')->name('portfolioCategoryDelete');

    // Portfolio
    Route::get('portfolio-list', 'PortfolioController@portfolioList')->name('portfolioList');
    Route::get('portfolio-create', 'PortfolioController@portfolioCreate')->name('portfolioCreate');
    Route::post('portfolio-save', 'PortfolioController@portfolioSave')->name('portfolioSave');
    Route::get('portfolio-edit/{id}', 'PortfolioController@portfolioEdit')->name('portfolioEdit');
    Route::get('portfolio-delete/{id}', 'PortfolioController@portfolioDelete')->name('portfolioDelete');
    Route::get('portfolio-img-delete', 'PortfolioController@deleteUploadedImage')->name('deleteUploadedImage');

    // Gallery Category
    Route::get('gallery-category-list', 'GalleryController@galleryCategoryList')->name('galleryCategoryList');
    Route::get('gallery-category-create', 'GalleryController@galleryCategoryCreate')->name('galleryCategoryCreate');
    Route::post('gallery-category-save', 'GalleryController@galleryCategorySave')->name('galleryCategorySave');
    Route::get('gallery-category-edit/{id}', 'GalleryController@galleryCategoryEdit')->name('galleryCategoryEdit');
    Route::get('gallery-category-delete/{id}', 'GalleryController@galleryCategoryDelete')->name('galleryCategoryDelete');

    // Gallery
    Route::get('gallery-list', 'GalleryController@galleryList')->name('galleryList');
    Route::get('gallery-create', 'GalleryController@galleryCreate')->name('galleryCreate');
    Route::post('gallery-save', 'GalleryController@gallerySave')->name('gallerySave');
    Route::get('gallery-edit/{id}', 'GalleryController@galleryEdit')->name('galleryEdit');
    Route::get('gallery-delete/{id}', 'GalleryController@galleryDelete')->name('galleryDelete');

    // Pricing plan
    Route::get('plan-list', 'PlanController@planList')->name('planList');
    Route::get('plan-create', 'PlanController@planCreate')->name('planCreate');
    Route::post('plan-save', 'PlanController@planSave')->name('planSave');
    Route::get('plan-edit/{id}', 'PlanController@planEdit')->name('planEdit');
    Route::get('plan-delete/{id}', 'PlanController@planDelete')->name('planDelete');

    // blog Category
    Route::get('blog-category-list', 'BlogController@blogCategoryList')->name('blogCategoryList');
    Route::get('blog-category-create', 'BlogController@blogCategoryCreate')->name('blogCategoryCreate');
    Route::post('blog-category-save', 'BlogController@blogCategorySave')->name('blogCategorySave');
    Route::get('blog-category-edit/{id}', 'BlogController@blogCategoryEdit')->name('blogCategoryEdit');
    Route::get('blog-category-delete/{id}', 'BlogController@blogCategoryDelete')->name('blogCategoryDelete');

    // blog
    Route::get('blog-list', 'BlogController@blogList')->name('blogList');
    Route::get('blog-create', 'BlogController@blogCreate')->name('blogCreate');
    Route::post('blog-save', 'BlogController@blogSave')->name('blogSave');
    Route::get('blog-edit/{id}', 'BlogController@blogEdit')->name('blogEdit');
    Route::get('blog-delete/{id}', 'BlogController@blogDelete')->name('blogDelete');

    Route::get('comment-list/{id}', 'BlogController@commentList')->name('commentList');
    Route::get('comment-details/{id}', 'BlogController@commentDetails')->name('commentDetails');
    Route::get('comment-approve', 'BlogController@commentApprove')->name('commentApprove');

    // menu
    Route::get('menu-list', 'MenuController@menuList')->name('menuList');
    Route::get('menu-create', 'MenuController@menuCreate')->name('menuCreate');
    Route::post('menu-save', 'MenuController@menuSave')->name('menuSave');
    Route::get('menu-edit/{id}', 'MenuController@menuEdit')->name('menuEdit');
    Route::get('menu-delete/{id}', 'MenuController@menuDelete')->name('menuDelete');
    Route::get('change-menu-order', 'MenuController@customMenuOrder')->name('customMenuOrder');
});