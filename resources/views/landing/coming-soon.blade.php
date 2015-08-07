@extends('landing.layout')

@section('landing-body')
<!-- ********** HEADER SECTION ********** -->
<div id="h">
    <div class="container">
        <div class="row centered">
            <h3 class="logo aligncenter"><img src="{{ asset('css/img/logos/aecore-topbar.svg') }}" alt=""></h3>

            <h1>You build it. We make it easy!</h1>
            <h2>Cloud-based construction management software for contractors.</h2>

            <div class="col-md-6 col-md-offset-3 mt">
                <form action="//aecorehq.us1.list-manage.com/subscribe/post?u=ca68b7b3212908c1f40a2cba5&amp;id=b7189d50f5" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate>
                    <input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="email address" required>
                    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
                    <div style="position: absolute; left: -5000px;"><input type="text" name="b_ca68b7b3212908c1f40a2cba5_b7189d50f5" tabindex="-1" value=""></div>
                    <button class='btn btn-lg btn-orange subscribe-submit' type="submit">Stay Informed</button>
                </form>
            </div>
        </div>
        <!--/row -->

        <div class="row">
            <div class="continue">
                <i class="ion-chevron-down"></i>
            </div>
        </div>
        <!--/row -->
    </div>
    <!--/container -->
</div><!--/header -->

<!-- ********** CALL TO ACTION SECTION ********** -->
<div id="cta">
    <div class="container">
        <div class="row">
            <h2>Do more with Aecore! We deliver easy-to-use tools so you can focus on building.</h2>
        </div>
        <!--/row -->
    </div>
    <!--/container -->
</div><!--/CTA -->


<!-- ********** FEATURES SECTION - Part 1 ********** -->
<div class="container mt">
    <div class="row">
        <div class="col-md-4 centered">
            <i class="ion-person orange big"></i>

            <p class="orange">Connect &amp; Share</p>

            <p class="text16">
                Real-time access to the latest RFI's, submittals, plans and more. It's never been this easy to stay connected.</p>
        </div>
        <!--/col-md-4-->
        <div class="col-md-4 centered">
            <i class="ion-cloud orange big"></i>

            <p class="orange">Welcome to "The Cloud"</p>

            <p class="text16">You no longer have to worry about FTP integration, IT nightmares or file distribution via email.</p>
        </div>
        <!--/col-md-4-->
        <div class="col-md-4 centered">
            <i class="ion-coffee orange big"></i>

            <p class="orange">The Daily Grind</p>

            <p class="text16">Spend less time trying to remember tasks and more time getting things done!</p>
        </div>
        <!--/col-md-4-->
    </div>
    <!--/row -->

    <div class="row mt">
        <div class="col-md-12">
            <img src="/landing/{{ $landingTheme }}/assets/img/display2.jpg" class="img-responsive aligncenter" alt=""
                 data-effect="slide-bottom">
        </div>
        <!--/col-md-12-->
    </div>
    <!--/row -->
</div><!--/container -->

<!-- ********** END SECTION ********** -->
<div class="container">
    <div class="row mtb">
        <div class="col-md-6 col-md-offset-3 centered">
            <p class="text28">
                <a href="http://twitter.com/aecorehq"><i class="ion-social-twitter"></i></a>
                <a href="http://www.linkedin.com/company/aecore"><i class="ion-social-linkedin"></i></a>
                <a href="https://www.facebook.com/aecore"><i class="ion-social-facebook"></i></a>
            </p>
            <hr class="aligncenter">
            <p>Aecore.com | Copyright 2015</p>
        </div>
    </div>
    <!--/row -->
</div><!--/container -->
@endsection
