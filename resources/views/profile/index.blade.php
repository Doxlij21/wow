<!doctype html>
<html style="min-width: 1410px; background-color: #69797e;">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="initial-scale=1.0001, minimum-scale=0.7, user-scalable=yes"/>
    <script src="/js/jquery-3.2.1.min.js"></script>
    @extends('css.maincss')
    <script src="/js/login/loginWrap.js"></script>
    <script src="/js/login/login.js"></script>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
</head>
<body style="display: none">
<div class="full-wrap">
    <div id="headerMover">
        <header>
        </header>
        <div id="content" class="indexNews">
            <div class="pageWidth">
                <div class="pageContent">
                    <div style="background: aqua;float:left;height: 500px;width: 150px;" id="profileMenu">
                        <form class="form" action="{{route('profile.post.menu', $user->id)}}" enctype="multipart/form-data">
                            <ul class="profileMenu">
                                <li class="profileMenuItem">
                                    <a href="#create static"> Create static </a>
                                </li>
                                <li class="profileMenuItem">
                                    <a href="#create static"> Battle.net account </a>
                                </li>
                            </ul>
                            {!! csrf_field() !!}
                        </form>
                    </div>
                    <div>
                        <script>
                            var profilemenuitem = $('.profileMenuItem');
                            var output = document.querySelector('#profileContent');
                            var form = $(".form");

                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            profilemenuitem.on("click", function(event) {
                                event.preventDefault();
                                var text = this.innerText;

                                $.ajax
                                ({
                                    type: 'POST',
                                    url: '{{route('profile.post.menu', $user->id)}}',
                                    data: { name: text },

                                    success:function(data)
                                    {
                                        console.log(text);
                                    }
                                    ,error:function(data)
                                    {
                                        debugger;
                                        alert("Error");
                                    }
                                });
                            });

                        </script>
                    </div>
                    <div style="background: brown;float: left;height: 500px;width: 1060px;" id="profileContent">
                        @if($menuFilter->menu_name == 'Create static')
                        <div id="static">
                            <div class="staticTitle">
                                <label for="staticTitle">Chose static title</label>
                                <input type="text" name="staticTitle">
                            </div>
                            <div class="staticCharacter">
                                <label for="staticCharacter">Select you'r character</label>
                                <ul id="staticCharacterOpt">
                                    @foreach($wowresponse->characters as $wowr)
                                        @if($wowr->level == 110)
                                            <li style="cursor: pointer">{{$wowr->name}} , {{$wowr->realm}} <img src="https://render-eu.worldofwarcraft.com/character/{{$wowr->thumbnail}}"></li>
                                        @else
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                            <div class="staticUsers">

                            </div>
                        </div>
                        @elseif($menuFilter->menu_name == 'Battle.net account')
                            <form target="_blank" method="get" action="{{route('battlenet.oauth' , \App\User::find(Auth::user()->id)->lang)}}">
                                <div id="battlenet">
                                    <div class="region">
                                        @if($check_token->exp >= time())
                                            <label for="region" class="control-label">Change you'r region</label>
                                        @else
                                            <label for="region" class="control-label">You'r region</label>
                                        @endif
                                            <select id="timezone" name="region">
                                                <option id="region" name="region" value='eu' > Europe </option>
                                                <option id="region" name="region" value='us' > USA </option>
                                                <option id="region" name="region" value='apac' > Asia-Pacific </option>
                                                <option id="region" name="region" value='cn' > China </option>
                                            </select>
                                    </div>
                                    <div>
                                        <div class="buttons" style="padding: 20px 0;border-top: 1px solid #dad8de;width: 100%;text-align: center;">
                                            <div class="form-group">
                                                <button type="submit" name="login" style="width: 71px;height: 32px;" class="primary button">
                                                    <span style="line-height: 0px !important;" class="js-login-text">
                                                        @if($check_token->exp >= time())
                                                            Change
                                                        @else
                                                            Bind
                                                        @endif
                                                    </span>
                                                </button>
                                                <script type="text/javascript">
                                                    function checkForm(form1)
                                                    {
                                                        form1.login.disabled = true;
                                                        form1.login.value = "Please wait...";
                                                        return true;
                                                    }
                                                </script>
                                            </div>
                                            <input type="hidden" name="_token" value="{{Session::token()}}">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div>
                                @if($check_token->exp >= time())
                                   hello {{$battlenetresponse->battletag}} with id {{$battlenetresponse->id}}
                                @else
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="overlays"></div>
</div>
<footer>
</footer>
</body>
<script src="/js/menu/menu.js"></script>
</html>