let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix
//        .sass('resources/sass/frontend/app.scss', 'public/css/frontend.css')
        .sass('resources/sass/frontend/home.scss', 'public/css/home.css')
        .sass('resources/sass/frontend/common.scss', 'public/css/common.css')
        .sass('resources/sass/frontend/landing-page.scss', 'public/css/landing-page.css')
        .sass('resources/sass/frontend/terms-conditions.scss', 'public/css/terms-conditions.css')
        .sass('resources/sass/frontend/about-us.scss', 'public/css/about-us.css')
        .sass('resources/sass/frontend/sale-rent-search.scss', 'public/css/sale-rent-search.css')
        .sass('resources/sass/frontend/vacation-search.scss', 'public/css/vacation-search.css')
        .sass('resources/sass/frontend/login.scss', 'public/css/login.css')
        .sass('resources/sass/frontend/contact.scss', 'public/css/contact.css')
        .sass('resources/sass/frontend/register.scss', 'public/css/register.css')
        .sass('resources/sass/frontend/profile-edit.scss', 'public/css/profile-edit.css')
        .sass('resources/sass/frontend/dashboard.scss', 'public/css/dashboard.css')
        .sass('resources/sass/frontend/make-an-offer.scss', 'public/css/make-an-offer.css')
        .sass('resources/sass/frontend/forum.scss', 'public/css/forum.css')
        .sass('resources/sass/frontend/blog.scss', 'public/css/blog.css')
        .sass('resources/sass/frontend/blog-single.scss', 'public/css/blog-single.css')
        .sass('resources/sass/frontend/property.scss', 'public/css/property.css')
        .sass('resources/sass/frontend/contract_tools.scss', 'public/css/contract_tools.css')
        .sass('resources/sass/frontend/contract-tools-buyer.scss', 'public/css/contract-tools-buyer.css')
        .sass('resources/sass/frontend/croppic.scss', 'public/css/croppic.css')       
        .sass('resources/sass/frontend/custom.scss', 'public/css/custom.css')       
        .sass('resources/sass/frontend/Pro-Service.scss', 'public/css/Pro-Service.css')
        .sass('resources/sass/frontend/landing-page-original.scss', 'public/css/landing-page-original.css')        
        .sass('resources/sass/frontend/banner.scss', 'public/css/banner.css')
               

        .js([
           'resources/js/frontend/app.js',
           'resources/js/frontend/commonFrontend.js', 
           
           'resources/js/frontend/croppic.min.js', 
           'resources/js/frontend/jquery.mask.js',           
           'resources/js/frontend/moment.min.js',  
           'resources/js/frontend/starr.min.js',
                      
           'resources/js/plugin/sweetalert/sweetalert.min.js',
           'resources/js/plugin/owl-carousel/owl-carousel.min.js',
           'resources/js/plugin/isotope/isotope.min.js',
           'resources/js/plugin/jquery-carousel/mousewheel.js',
           'resources/js/plugin/jquery-carousel/jquery-carousel.min.js',
           'resources/js/plugin/select2/select2.min.js',
           'resources/js/plugin/jquery-validate/jquery.validate.min.js',
           'resources/js/plugin/underscore/underscore.min.js',
           'resources/js/jquery.nicescroll.min.js',
           'resources/js/plugins.js'
        ], 'public/js/frontend.js')
        
        .js([
           'resources/js/frontend/property.js',
        ], 'public/js/property.js')

        .sass('resources/sass/backend/app.scss', 'public/css/backend.css')

        .js([
           'resources/js/backend/app.js',
           'resources/js/backend/script.js',
           'resources/js/plugin/sweetalert/sweetalert.min.js',
           'resources/js/plugin/jquery-validate/jquery.validate.min.js',
           'resources/js/plugins.js'
        ], 'public/js/backend.js')

        .options({processCssUrls: false});
if (mix.inProduction) {
   mix.version();
}