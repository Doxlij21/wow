
<div class="menuMenu" id="menuMenu">
    MENU
    <i style="margin-left: 10px" class="fa fa-bars fa-6" aria-hidden="true"></i>
</div>

<div class="menuHover" id="menuHover" style="display:none">
    <nav>
        <ul class="menu">
            <div class="userbar">
                @if (Auth::check())
                    <div style="float: left;margin-right: 10px;" class="hello">
                        notifications
                            <i class="fa fa-user" aria-hidden="true"></i>
                        <?php
                            if (\Illuminate\Support\Facades\Auth::guest()) {
                                if (\Illuminate\Support\Facades\Session::has('lang')) {
                                    $lang = \Illuminate\Support\Facades\Session::get('lang');
                                } else {
                                    $lang = \Illuminate\Support\Facades\Config::get('app.locale');
                                }
                            } else {
                                $lang = \App\User::find(\Illuminate\Support\Facades\Auth::user()->id)->lang;
                            }
                        ?>
                        <a href="{{ route('profile.index' , $lang )}}">{{Auth::user()->username}}</a>
                    </div>

                    <a href="{{ route('logout') }}" style="display: block; float: left;" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out" aria-hidden="true"></i>Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                @else
                    <div class="helloGuests">
                        <a href='#login' onclick='login()'>Login</a>
                        or
                        <a href='#register' onclick='register()'>Register</a>
                    </div>
                @endif
            </div>
        </ul>
    </nav>
</div>