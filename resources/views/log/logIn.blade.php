
<!DOCTYPE html>
<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 4 & Angular 7
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en" >
<!-- begin::Head -->
<head>
    <meta charset="utf-8"/>
    <base href="{{url('/')}}">
    <title>Metronic | Login Page 4</title>
    <meta name="description" content="Login page example">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!--begin::Fonts -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
        WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>
    <!--end::Fonts -->



    <!--begin::Page Custom Styles(used by this page) -->
    <link href="./assets/css/demo2/pages/custom/general/login/login-4.css" rel="stylesheet" type="text/css" />
    <!--end::Page Custom Styles -->

    <!--begin::Global Theme Styles(used by all pages) -->
    <link href="./assets/vendors/global/vendors.bundle.css" rel="stylesheet" type="text/css" />
    <link href="./assets/css/demo2/style.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles -->

    <!--begin::Layout Skins(used by all pages) -->
    <!--end::Layout Skins -->

    <link rel="shortcut icon" href="./assets/media/logos/favicon.ico" />
    <!-- Hotjar Tracking Code for keenthemes.com -->
    <script>
        (function(h,o,t,j,a,r){
            h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
            h._hjSettings={hjid:1070954,hjsv:6};
            a=o.getElementsByTagName('head')[0];
            r=o.createElement('script');r.async=1;
            r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
            a.appendChild(r);
        })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
    </script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-37564768-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-37564768-1');
    </script>
</head>
<!-- end::Head -->

<!-- begin::Body -->
<body  class="kt-page--loading-enabled kt-page--loading kt-page--fixed kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header--minimize-topbar kt-header-mobile--fixed kt-subheader--enabled kt-subheader--transparent kt-page--loading"  >

<!-- begin::Page loader -->

<!-- end::Page Loader -->
<!-- begin:: Page -->
<div class="kt-grid kt-grid--ver kt-grid--root kt-page">
    <div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v4 kt-login--signin" id="kt_login">

        <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" style="background-image: url(./assets/media/bg/bg-2.jpg);">

                <img alt="Logo" style="position: absolute;right: 47%;width: 89px;padding-top: 8.5%;" src="https://upload.wikimedia.org/wikipedia/en/thumb/b/b8/EMU_Cyprus.svg/1200px-EMU_Cyprus.svg.png" class="kt-header__brand-logo-default">

            <div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper" style="padding-top: 12.5%;">

                <div class="kt-login__container">

                    <div class="kt-login__logo">
                        <a href="#">

                        </a>
                    </div>
                    <div class="kt-login__signin">
                        <div class="kt-login__head">
                            <h3 class="kt-login__title"></h3>
                        </div>
                        <form class="kt-form" action="{{route("login")}}">
                            {{csrf_token()}}
                            <div class="input-group">
                                <input class="form-control" type="text" placeholder="Email" name="email" autocomplete="off">
                            </div>
                            <div class="input-group">
                                <input class="form-control" type="password" placeholder="Password" name="password">
                            </div>
                            <div class="row kt-login__extra">
                                <div class="col">
                                    <label class="kt-checkbox">
                                        <input type="checkbox" name="remember"> Remember me
                                        <span></span>
                                    </label>
                                </div>
                                <div class="col kt-align-right">
                                    <a href="javascript:;" id="kt_login_forgot" class="kt-login__link">Forget Password ?</a>
                                </div>
                            </div>
                            <div class="kt-login__actions">

                                <button id="kt_login_signin_submit" class="btn btn-brand btn-pill kt-login__btn-primary">Sign In
                                    <a href="http://localhost:8000/api/admin/offered_course/browser"></a>
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="kt-login__signup">
                        <div class="kt-login__head">
                            <h3 class="kt-login__title">Sign Up</h3>
                            <div class="kt-login__desc">Enter your details to create your account:</div>
                        </div>
                        <form class="kt-form" action="">
                            <div class="input-group">
                                <input class="form-control" type="text" placeholder="Fullname" name="fullname">
                            </div>
                            <div class="input-group">
                                <input class="form-control" type="text" placeholder="Email" name="email" autocomplete="off">
                            </div>
                            <div class="input-group">
                                <input class="form-control" type="password" placeholder="Password" name="password">
                            </div>
                            <div class="input-group">
                                <input class="form-control" type="password" placeholder="Confirm Password" name="rpassword">
                            </div>
                            <div class="row kt-login__extra">
                                <div class="col kt-align-left">
                                    <label class="kt-checkbox">
                                        <input type="checkbox" name="agree">I Agree the <a href="#" class="kt-link kt-login__link kt-font-bold">terms and conditions</a>.
                                        <span></span>
                                    </label>
                                    <span class="form-text text-muted"></span>
                                </div>
                            </div>
                            <div class="kt-login__actions">
                                <button id="kt_login_signup_submit" class="btn btn-brand btn-pill kt-login__btn-primary">Sign Up</button>&nbsp;&nbsp;
                                <button id="kt_login_signup_cancel" class="btn btn-secondary btn-pill kt-login__btn-secondary">Cancel</button>
                            </div>
                        </form>
                    </div>
                    <div class="kt-login__forgot">
                        <div class="kt-login__head">
                            <h3 class="kt-login__title">Forgotten Password ?</h3>
                            <div class="kt-login__desc">Enter your email to reset your password:</div>
                        </div>
                        <form class="kt-form" action="">
                            <div class="input-group">
                                <input class="form-control" type="text" placeholder="Email" name="email" id="kt_email" autocomplete="off">
                            </div>
                            <div class="kt-login__actions">
                                <button id="kt_login_forgot_submit" class="btn btn-brand btn-pill kt-login__btn-primary">Request</button>&nbsp;&nbsp;
                                <button id="kt_login_forgot_cancel" class="btn btn-secondary btn-pill kt-login__btn-secondary">Cancel</button>
                            </div>
                        </form>
                    </div>
                    <div class="kt-login__account">

                        &nbsp;&nbsp;

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- end:: Page -->


<!-- begin::Global Config(global config for global JS sciprts) -->
<script>
    var KTAppOptions = {"colors":{"state":{"brand":"#374afb","light":"#ffffff","dark":"#282a3c","primary":"#5867dd","success":"#34bfa3","info":"#36a3f7","warning":"#ffb822","danger":"#fd3995"},"base":{"label":["#c5cbe3","#a1a8c3","#3d4465","#3e4466"],"shape":["#f0f3ff","#d9dffa","#afb4d4","#646c9a"]}}};
</script>
<!-- end::Global Config -->

<!--begin::Global Theme Bundle(used by all pages) -->
<script src="./assets/vendors/global/vendors.bundle.js" type="text/javascript"></script>
<script src="./assets/js/demo2/scripts.bundle.js" type="text/javascript"></script>
<!--end::Global Theme Bundle -->




<!--begin::Page Scripts(used by this page) -->
<script src="./assets/js/demo2/pages/login/login-general.js" type="text/javascript"></script>
<!--end::Page Scripts -->
</body>
<!-- end::Body -->
</html>
