<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Google tag (gtag.js) --> <script async src="https://www.googletagmanager.com/gtag/js?id=G-002F57542L"></script> <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'G-002F57542L'); </script>
    <!-- Required meta tags-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Place holder for laravel token-->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{asset('favicon.ico')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    
    <meta property="og:url"  content="https://www.tridentmarineasia.com" />
<meta property="og:type"  content="article" />
<meta property="og:title"  content="TRIDENT MARINE ASIA" />
<meta property="og:description"   content="Provides PPCDL and competency courses, skippered and bareboat yacht charters, boating maintenance & engineering, yacht broker & boating services" />
<meta property="og:image"  content="https://www.tridentmarineasia.com/images/logo.png" />
 <meta property="fb:app_id"   content="631857140869964" /> 
    <!-- App CSS-->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-select.min.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.8.2/fullcalendar.min.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>      
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    <title>@yield('title', 'TRIDENT MARINE ASIA')</title>
</head>
<body>
<main id="page">
@component('header')
@endcomponent

@yield('content')

@component('footer')
@endcomponent

@yield('forgot_script')
</main>
@component('elements.login')
@endcomponent

@component('elements.register')
@endcomponent

@component('elements.resetPassword')
@endcomponent

@component('elements.enquiry')
@endcomponent

{{--@component('elements.wire-transfer')
@endcomponent--}}

@component('elements.contact-enquiry')
@endcomponent

{{--@component('elements.paypal-confirm')
@endcomponent--}}
<!-- App Javascript-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
<script src="{{asset('js/app.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.8.2/fullcalendar.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

 
@if(Session::has('adminlogin'))
<script src="{{asset('js/custom-admin.js')}}"></script>
@else
<script src="{{asset('js/custom.js')}}"></script>
@endif 
<!-- Latest compiled and minified JavaScript-->
<script src="{{asset('js/bootstrap-select.min.js')}}"></script>
<script src="{{asset('js/bootstrap-select.js')}}"></script>
<script src="{{asset('js/countries.js')}}"></script>
<?php if(isset($_GET['open'])=="login"){
 echo '<script>jQuery( "#loginpop" ).trigger( "click" );</script>';
} if(isset($_GET['openp'])=="register"){
 echo '<script>jQuery( "#registerpop" ).trigger( "click" );</script>';
}
?>@if(request()->route()->getName() == 'home')
<script>
  function nFormatter(num){
    if(num >= 1000000000){
      return (num/1000000000).toFixed(1).replace(/\.0$/,'') + 'G';
    }
    if(num >= 1000000){
      return (num/1000000).toFixed(1).replace(/\.0$/,'') + 'M';
    }
    if(num >= 1000){
      return (num/1000).toFixed(1).replace(/\.0$/,'') + 'K';
    }
    return num;
  }
  jQuery.ajax({
    url:"https://www.instagram.com/tridentmarineasia?__a=1",
    type:'get',
    crossDomain: true,
    headers : {
              'Content-type': 'application/json',
              "Access-Control-Allow-Origin":"*"
          },
    success:function(response){
      
      $(".profile-pic").attr('src',response.graphql.user.profile_pic_url);
      $(".name").html(response.graphql.user.full_name);
      $(".biography").html(response.graphql.user.biography);
      $(".username").html(response.graphql.user.username);
      $(".number-of-posts").html(response.graphql.user.edge_owner_to_timeline_media.count);
      $(".followers").html(nFormatter(response.graphql.user.edge_followed_by.count));
      $(".following").html(nFormatter(response.graphql.user.edge_follow.count));
      posts = response.graphql.user.edge_owner_to_timeline_media.edges;
      posts_html = '';
      for(var i=0;i<4;i++){
       // url = posts[i].node.display_url;
         url = posts[i].node.thumbnail_src;
        likes = posts[i].node.edge_liked_by.count;
        comments = posts[i].node.edge_media_to_comment.count;
        shortcode= posts[i].node.shortcode ;
        posts_html += '<div class="col-md-3  col-sm-6 col-12 equal-height bg-light p-2"><div class="instagram-photo"><a href="https://www.instagram.com/p/'+shortcode+'" target="_blank"><img style="min-height:50px;background-color:#fff;width:100%" src="'+url+'"></a></div><div class="row like-comment"><div class="col-md-6 text-left"><small>'+nFormatter(likes)+' LIKES</small></div><div class="col-md-6 text-left"><small>'+nFormatter(comments)+' COMMENTS</small></div></div></div>';
      }
      jQuery(".insposts").html(posts_html);
    }
  });
</script>@endif 
<script type="text/javascript">window.$crisp=[];window.CRISP_WEBSITE_ID="35a4e894-6733-4cf8-a7ff-4314503568a3";(function(){d=document;s=d.createElement("script");s.src="https://client.crisp.chat/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();</script>
<script type="text/javascript">
        $(document).ready(function() {
            window.history.pushState(null, "", window.location.href); 
            window.onpopstate = function() {
                window.history.pushState(null, "", window.location.href);
            };
        });
    </script>  
  @stack('scripts')   
@yield('js')
</body>
</html>
