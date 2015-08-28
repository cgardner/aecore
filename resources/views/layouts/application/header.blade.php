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
    <li class="dropdown" id="mynotifications">
        @include('layouts.application.notifications')
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

<script>
    // Include the UserVoice JavaScript SDK (only needed once on a page)
    UserVoice=window.UserVoice||[];(function(){var uv=document.createElement('script');uv.type='text/javascript';uv.async=true;uv.src='//widget.uservoice.com/qWqCy91XFzLF8V4SL9MKQg.js';var s=document.getElementsByTagName('script')[0];s.parentNode.insertBefore(uv,s)})();

    // Set colors
    UserVoice.push(['set', {
        accent_color: '#DA4B4B',
        trigger_color: 'white',
        trigger_background_color: '#DA4B4B'
    }]);

    // Identify the user and pass traits
    // To enable, replace sample data with actual user traits and uncomment the line
    UserVoice.push(['identify', {
        email:      '{!! \Auth::User()->email !!}',
        name:       '{!! \Auth::User()->name !!}', // User�s real name
        account: {
            id:           '{!! \Auth::User()->company->id !!}',
            name:         '{!! \Auth::User()->company->name !!}',
        }
    }]);

    // Add default trigger to the bottom-right corner of the window:
    UserVoice.push(['addTrigger', { mode: 'contact', trigger_position: 'bottom-left' }]);

    // Autoprompt for Satisfaction and SmartVote (only displayed under certain conditions)
    UserVoice.push(['autoprompt', {}]);
</script>