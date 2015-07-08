<?php
    $notifications = Auth::User()->getNotifications();
?>

<div class="navbar-header">
  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
    <span class="sr-only">Toggle navigation</span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
  </button>
  @if (Auth::check())
    {!! link_to('projects', '', array('class' => 'navbar-brand')) !!}
  @else
    {!! link_to('home', '', array('class' => 'navbar-brand')) !!}
  @endif
</div>
<div class="collapse navbar-collapse" id="navbar-collapse">
  <ul class="nav navbar-nav">
    <li>{!! link_to('projects', 'Projects', array('class' => Request::is('projects*') ? 'navbar-link-active' : 'navbar-link')) !!}</li>
    <li>{!! link_to('tasks', 'Tasks', array('class' => Request::is('tasks*') ? 'navbar-link-active' : 'navbar-link')) !!}</li>
  </ul>
  <ul class="nav navbar-nav navbar-right">
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
            <span class="glyphicon glyphicon-bell" style="top:3px;"></span>
            @if(count($notifications) > 0)
                <span class="label label-sm label-danger">{{ count($notifications) }}</span>
            @endif
        </a>
        <ul class="dropdown-menu" role="menu" style="width:350px;padding:0;">
            <li role="presentation" class="dropdown-header" style="padding:8px 12px;">My Notifications</li>
            @if(count($notifications) > 0)
                @foreach($notifications as $notification)
                    <div data-notification-id="{{ $notification->id }}" data-notification-url="{{ $notification->url }}">
                        <div class="notification-tile {{ ($notification->read == 0) ? 'bold' : '' }}">
                            <img src="{{ $notification->from->gravatar }}" class="avatar_sm"/>
                            <p>{{ $notification->text }}</p>
                            <p class="text-muted">{{ \Carbon\Carbon::createFromTimeStamp(strtotime($notification->created_at))->diffForHumans() }}</p>
                        </div>
                    </div>
                @endforeach
            @else
                <p style="font-size:7em;line-height:1em;color:#ccc;" class="center"><span class="glyphicon glyphicon-bell"></span></p>
                <p style="padding:0 12px;" class="center text-muted">"The most important thing in communication<br>is hearing what isn't said"<br><i>-Peter Drucker</i></p>
            @endif
        </ul>
    </li>
    
    <li class="dropdown">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><img src="{!! Auth::user()->gravatar !!}" class="avatar_navbar" />{!! Auth::user()->username !!} <span class="caret"></span></a>
      <ul class="dropdown-menu" role="menu">
        <li role="presentation" class="dropdown-header">
            <strong>{!! Auth::User()->name !!}</strong><br>
            {!! Auth::User()->email !!}
        </li>
        <!--<li><a href="/profile/{!! Auth::User()->username !!}" title="View your profile."><span class="glyphicon glyphicon-user small"></span> Profile</a></li>-->
        <li><a href="/settings/profile" title="Edit your settings."><span class="glyphicon glyphicon-cog small"></span> Settings</a></li>
        <li class="divider"></li>
        <li><a href="/auth/logout" title="Log out of Aecore."><span class="glyphicon glyphicon-off small"></span> Log Out</a></li>
      </ul>
    </li>
  </ul>
</div>

@section('endbody')
    <script>
        (function ($, location) {
            'use strict';
            $('.notification-tile').click(function () {
                readNotification(this);
            });

            function findNotificationId(context) {
                return $(context).parents('[data-notification-id]').attr('data-notification-id');
            };
            function findNotificationUrl(context) {
                return $(context).parents('[data-notification-id]').attr('data-notification-url');
            };

            function readNotification(context, newData) {
                var data = $.extend({_token: token}, newData);
                $.ajax({
                    url: "/notifications/read/" + findNotificationId(context),
                    method: "POST",
                    data: data,
                    success: function() {
                       window.location.href = findNotificationUrl(context);
                    }
                });
            }
            var token = "{{ \Session::token() }}";
        })(jQuery, location);
    </script>
@endsection