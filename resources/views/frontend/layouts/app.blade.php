<!doctype html>
<html lang="{{ app()->getLocale() }}">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="csrf-token" content="{{ csrf_token() }}">

      <title>@yield('title', app_name())</title>

      <!-- Meta -->
      <meta name="description" content="@yield('meta_description', '')">
      <meta name="keywords" content="@yield('meta_keywords', '')">
      <!--@yield('meta')-->

      <!-- Styles -->
      @yield('before-styles')
      <link type="text/css" rel="stylesheet" href="{{ asset(mix('css/common.css')) }}" media="all">
      <link type="text/css" rel="stylesheet" href="{{ asset('css/custom.css') }}" media="all">


      @yield('after-styles')

      <!-- Scripts -->
      <script>
         window.Laravel = <?php echo json_encode(['csrfToken' => csrf_token()]); ?>
      </script>
   </head>

   <body class="skin-{{ config('frontend.theme') }} {{ config('frontend.layout') }}">
      @include('includes.partials.logged-in-as')

      <div class="wrapper">
         @include('frontend.includes.header')

         <!-- Content Wrapper. Contains page content -->
         <div class="content-wrapper">                   
            <!-- Main content -->
            <section class="content">
               <div class="loader" style="display: none;">
                  <div class="ajax-spinner ajax-skeleton"></div>
               </div><!--loader-->

               @include('includes.partials.messages')
               @yield('content')
            </section><!-- /.content -->
         </div><!-- /.content-wrapper -->

         @include('frontend.includes.footer')
      </div><!-- ./wrapper -->

      <!-- JavaScripts -->
      @yield('before-scripts')
      <script src="{{ asset(mix('js/frontend.js')) }}"></script>
      @yield('after-scripts')
      <script>
        $(document).ready(function () {
          $(':input[type=number]').on('mousewheel', function (e) {
              $(this).blur();
          });
        });
        $(window).on('load',function(){
            setTimeout(function () {
                $('.alert-success, .alert-danger, .alert-warning').fadeOut('fast');
            }, 4000);
        });
      </script>
   </body>

</html>
