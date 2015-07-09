<?php
    $notifications = Auth::User()->getNotifications();
?>

    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
        <span class="glyphicon glyphicon-bell" style="top:3px;"></span>
        @if(count($notifications) > 0)
            <span class="label label-sm label-danger">{{ count($notifications) }}</span>
        @endif
    </a>
    <ul class="dropdown-menu" role="menu" style="width:350px;padding:0;">
        @if(count($notifications) > 0)
            <span class="btn-link small pull-right" style="margin:8px 12px 0 0;" onClick="readAllNotifications();">Clear All</span>
        @endif
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