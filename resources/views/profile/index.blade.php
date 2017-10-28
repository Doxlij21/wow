<!doctype html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="initial-scale=1.0001, minimum-scale=0.7, user-scalable=yes"/>
    <script src="/js/jquery-3.2.1.min.js"></script>
    @extends('css.profilecss')
    <script src="/js/login/loginWrap.js"></script>
    <script src="/js/login/login.js"></script>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
</head>
<body>

<header>
    <div id="allmenu">
        <ul id="gn-menu" class="gn-menu-main">
            <li class="gn-trigger">
                <a class="menu-bars">
                    <i class="fa fa-bars"></i>

                </a>
            <li id="logo"><a href="#"><img src="/img/profile/logo2.png"></a></li>
            <div id="Navigation">
                <ul class="Navigation">
                    <li><a href="#" class="fa fa-user"></a>
                        <ul>
                            <li><a href="/profile">Profile</a></li>
                            <li><a href="/logout" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out" aria-hidden="true"></i>Logout
                                </a>
                                <form id="logout-form" action="/logout" method="POST" style="display: none;">
                                    <input type="hidden" name="_token" value="IMiRSRKT5Tn3EKMm4EyQFjqD6cuerladLJu85bBu">
                                </form>
                            </li>
                        </ul>
                    </li>
                    <li><a href="#" class="fa fa-envelope-o"></a>
                        <ul>
                            <li><a href="#win1">New</a></li>
                        </ul>
                    </li>

                    <li><a href="#" class="fa fa-globe"></a>
                        <ul>
                            <li>
                                <a href="{{ route('profile.index' , \App\User::find(Auth::user()->id)->lang) }}">
                                    <img src="/img/profile/eng.jpg">
                                </a>
                                <input type="hidden" name="_token" value="IMiRSRKT5Tn3EKMm4EyQFjqD6cuerladLJu85bBu">
                            </li>
                            <li>
                                <a href="{{ route('profile.index' , \App\User::find(Auth::user()->id)->lang) }}">
                                    <img src="/img/profile/ru.jpg">
                                </a>
                                <input type="hidden" name="_token" value="IMiRSRKT5Tn3EKMm4EyQFjqD6cuerladLJu85bBu">
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>

            <nav class="gn-menu-wrapper">
                <!-- ... /-->
                <div class="gn-scroller">
                    <ul class="gn-menu">
                        <li class="gn-search-item">
                            <input placeholder="Search" type="search" class="gn-search">
                            <a href="#"><i class="fa fa-search"></i><span>Search</span></a></li>
                        <li><a href="#"><i class="fa fa-file-o"></i> Page1</a></li>
                        <li><a href="#"><i class="fa fa-file-o"></i> Page2</a></li>
                        <li><a href="#"><i class="fa fa-file-o"></i> Page3</a></li>
                        <li><a href="#"><i class="fa fa-cog"></i> Настройки</a></li>
                        <!-- ... /-->
                    </ul>
                </div>
                <!-- ... /-->
            </nav>

        </ul>
    </div>
</header>
<content>
                <div id="content">
                    <div id="title">Create Static</div>
                    <div id="profileMenu">
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
                    <div id="profileContent">
                        @if($menuFilter->menu_name == 'Create static')
                            @if(count($user->battlenet_token) > 0)
                                <form class="form" action="{{route('profile.create.static')}}" enctype="multipart/form-data" onSubmit="return check()">
                                    <div id="static" style="float: left;">
                                        <div id="staticTitle">
                                            <label for="static_name">Chose static title</label>
                                            <input id="static_name" type="text" name="static_name">
                                        </div>
                                        <div class="staticCharacter">
                                            <label for="staticCharacter">Select static RL</label>
                                            <ul id="staticCharacterOpt">
                                                @foreach($wowresponse->characters as $wowr)
                                                    @if($wowr->level == 110)
                                                        <li>{{$wowr->name}} , {{$wowr->realm}} <img src="https://render-eu.worldofwarcraft.com/character/{{$wowr->thumbnail}}"></li>
                                                        <div id="transferSelectedCharacter" style="display: none">
                                                            <div id="selectedthischaracter">Selected RL this character:</div>
                                                            <div>
                                                                 {{$wowr->name}} , {{$wowr->realm}} <img src="https://render-eu.worldofwarcraft.com/character/{{$wowr->thumbnail}}">
                                                                <input name="charactername" value="{{$wowr->name}}" style="display: none">
                                                            </div>
                                                            <div>
                                                                In this guild: {{$wowr->guild}}
                                                                <input id="guildnameinput" name="guildname" value="{{$wowr->guild}}" style="display: none">
                                                                <input id="guildserverinput" name="guildserver" value="{{$wowr->guildRealm}}" style="display: none">
                                                            </div>
                                                        </div>
                                                    @else
                                                    @endif
                                                @endforeach
                                            </ul>

                                            <div id="selectedStaticCharacter">

                                            </div>
                                            <div id="staticHelper">
                                                <div class="helperWrap">
                                                    <div class="first">
                                                        <span class="pending">Choose you'r static title <a href="#static_name"><i class="fa fa-hand-pointer-o" aria-hidden="true"></i></a></span>
                                                        <span style="color: green;display: none" class="done"></span>
                                                        <span style="color: red;display: none" class="error"></span>
                                                    </div>
                                                    <div style="width: 240.844px;" class="second">
                                                        <span class="pending">Choose static rl<a href="#staticCharacterOpt"><i class="fa fa-hand-pointer-o" aria-hidden="true"></i></a></span>
                                                        <span style="color: green;display: none" class="done"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="staticUsers">
                                            @if (count(request()->guildserver) > 0)
                                                <?php
                                                    $guildserver = $_GET['guildserver'];
                                                    $guildname = str_replace(' ', '%20',$_GET['guildname']);
                                                    $apikey = "27hkqmbn3y4ew7gsr66pqvnf7gfqtb43";
                                                    $parseguild = json_decode(file_get_contents("https://$user->battlenet_region.api.battle.net/wow/guild/$guildserver/$guildname?fields=members&apikey=$apikey"));
                                                    $filteredguild = collect($parseguild->members)->where('character.level','110');
                                                ?>
                                                    <div style="width: auto;" class="third">
                                                        <span class="pending">Select static members:</span>
                                                        <span style="color: green;display: none" class="done">Selected static members:</span>
                                                        <span style="color: red;display: none" class="error"></span>
                                                    </div>
                                                <div id="classFilterWrap">
                                                    <ul class="mytabs" id="classFilter">
                                                        <li class="" data-cat-class="Warrior"><a class="Warrior">Warrior</a></li>
                                                        <li class="" data-cat-class="Paladin"><a class="Paladin">Paladin</a></li>
                                                        <li class="" data-cat-class="Hunter"><a class="Hunter">Hunter</a></li>
                                                        <li class="" data-cat-class="Rogue"><a class="Rogue">Rogue</a></li>
                                                        <li class="" data-cat-class="Priest"><a class="Priest">Priest</a></li>
                                                        <li class="" data-cat-class="Death Knight"><a class="Deathknight">Death Knight</a></li>
                                                        <li class="" data-cat-class="Shaman"><a class="Shaman">Shaman</a></li>
                                                        <li class="" data-cat-class="Mage"><a class="Mage">Mage</a></li>
                                                        <li class="" data-cat-class="Warlock"><a class="Warlock">Warlock</a></li>
                                                        <li class="" data-cat-class="Monk"><a class="Monk">Monk</a></li>
                                                        <li class="" data-cat-class="Druid"><a class="Druid">Druid</a></li>
                                                        <li class="" data-cat-class="Demon Hunter"><a class="Demonhunter">Demon Hunter</a></li>
                                                        <li class="" data-cat-class="All"><a class="All">All</a></li>
                                                    </ul>
                                                </div>
                                                    <div class="mytabs-container" id="tabs-container">
                                                <div id="selectCharacters">
                                                @if(count(request()->class) > 0)
                                                    @foreach($filteredguild as $fguild)
                                                            @if($_GET['class'] == 'All')
                                                                @if($fguild->character->class == 1)
                                                                    <div class="active" id="Warrior" dataclass="Warrior">
                                                                        <input id="{{$fguild->character->name}}" name="character_name[]" value="{{$fguild->character->name}}" type="checkbox"> <span class="Warrior">{{$fguild->character->name}}</span>
                                                                    </div>
                                                                @elseif($fguild->character->class == 2)
                                                                    <div class="active" id="Paladin" dataclass="Paladin">
                                                                        <input id="{{$fguild->character->name}}" name="character_name[]" value="{{$fguild->character->name}}" type="checkbox"> <span class="Paladin">{{$fguild->character->name}}</span>
                                                                    </div>
                                                                @elseif($fguild->character->class == 3)
                                                                    <div class="active" id="Hunter" dataclass="Hunter">
                                                                        <input id="{{$fguild->character->name}}" name="character_name[]" value="{{$fguild->character->name}}" type="checkbox"> <span class="Hunter">{{$fguild->character->name}}</span>
                                                                    </div>
                                                                @elseif($fguild->character->class == 4)
                                                                    <div class="active" id="Rogue" dataclass="Rogue">
                                                                        <input id="{{$fguild->character->name}}" name="character_name[]" value="{{$fguild->character->name}}" type="checkbox"> <span class="Rogue">{{$fguild->character->name}}</span>
                                                                    </div>
                                                                @elseif($fguild->character->class == 5)
                                                                    <div class="active" id="Priest" dataclass="Priest">
                                                                        <input id="{{$fguild->character->name}}" name="character_name[]" value="{{$fguild->character->name}}" type="checkbox"> <span class="Priest">{{$fguild->character->name}}</span>
                                                                    </div>
                                                                @elseif($fguild->character->class == 6)
                                                                    <div class="active" id="Death Knight" dataclass="Death Knight">
                                                                        <input id="{{$fguild->character->name}}" name="character_name[]" value="{{$fguild->character->name}}" type="checkbox"> <span class="Deathknight">{{$fguild->character->name}}</span>
                                                                    </div>
                                                                @elseif($fguild->character->class == 7)
                                                                    <div class="active" id="Shaman" dataclass="Shaman">
                                                                        <input id="{{$fguild->character->name}}" name="character_name[]" value="{{$fguild->character->name}}" type="checkbox"> <span class="Shaman">{{$fguild->character->name}}</span>
                                                                    </div>
                                                                @elseif($fguild->character->class == 8)
                                                                    <div class="active" id="Mage" dataclass="Mage">
                                                                        <input id="{{$fguild->character->name}}" name="character_name[]" value="{{$fguild->character->name}}" type="checkbox"> <span class="Mage">{{$fguild->character->name}}</span>
                                                                    </div>
                                                                @elseif($fguild->character->class == 9)
                                                                    <div class="active" id="Warlock" dataclass="Warlock">
                                                                        <input id="{{$fguild->character->name}}" name="character_name[]" value="{{$fguild->character->name}}" type="checkbox"> <span class="Warlock">{{$fguild->character->name}}</span>
                                                                    </div>
                                                                @elseif($fguild->character->class == 10)
                                                                    <div class="active" id="Monk" dataclass="Monk">
                                                                        <input id="{{$fguild->character->name}}" name="character_name[]" value="{{$fguild->character->name}}" type="checkbox"> <span class="Monk">{{$fguild->character->name}}</span>
                                                                    </div>
                                                                @elseif($fguild->character->class == 11)
                                                                    <div class="active" id="Druid" dataclass="Druid">
                                                                        <input id="{{$fguild->character->name}}" name="character_name[]" value="{{$fguild->character->name}}" type="checkbox"> <span class="Druid">{{$fguild->character->name}}</span>
                                                                    </div>
                                                                @elseif($fguild->character->class == 12)
                                                                    <div class="active" id="Demon Hunter" dataclass="Demon Hunter">
                                                                        <input id="{{$fguild->character->name}}" name="character_name[]" value="{{$fguild->character->name}}" type="checkbox"> <span class="Demonhunter">{{$fguild->character->name}}</span>
                                                                    </div>
                                                                @endif
                                                            @else
                                                            @endif
                                                        @if($fguild->character->class == 1)
                                                            @if($_GET['class'] == 'Warrior')
                                                                <div class="active" id="Warrior" dataclass="Warrior">
                                                                    <input id="{{$fguild->character->name}}" name="character_name[]" value="{{$fguild->character->name}}" type="checkbox"> <span class="Warrior">{{$fguild->character->name}}</span>
                                                                </div>
                                                            @else
                                                            @endif
                                                        @elseif($fguild->character->class == 2)
                                                            @if($_GET['class'] == 'Paladin')
                                                                <div class="active" id="Paladin" dataclass="Paladin">
                                                                    <input id="{{$fguild->character->name}}" name="character_name[]" value="{{$fguild->character->name}}" type="checkbox"> <span class="Paladin">{{$fguild->character->name}}</span>
                                                                </div>
                                                            @else
                                                            @endif
                                                        @elseif($fguild->character->class == 3)
                                                            @if($_GET['class'] == 'Hunter')
                                                                <div class="active" id="Hunter" dataclass="Hunter">
                                                                    <input id="{{$fguild->character->name}}" name="character_name[]" value="{{$fguild->character->name}}" type="checkbox"> <span class="Hunter">{{$fguild->character->name}}</span>
                                                                </div>
                                                            @else
                                                            @endif
                                                        @elseif($fguild->character->class == 4)
                                                            @if($_GET['class'] == 'Rogue')
                                                                <div class="active" id="Rogue" dataclass="Rogue">
                                                                    <input id="{{$fguild->character->name}}" name="character_name[]" value="{{$fguild->character->name}}" type="checkbox"> <span class="Rogue">{{$fguild->character->name}}</span>
                                                                </div>
                                                            @else
                                                            @endif
                                                        @elseif($fguild->character->class == 5)
                                                            @if($_GET['class'] == 'Priest')
                                                                <div class="active" id="Priest" dataclass="Priest">
                                                                    <input id="{{$fguild->character->name}}" name="character_name[]" value="{{$fguild->character->name}}" type="checkbox"> <span class="Priest">{{$fguild->character->name}}</span>
                                                                </div>
                                                            @else
                                                            @endif
                                                        @elseif($fguild->character->class == 6)
                                                            @if($_GET['class'] == 'Death Knight')
                                                                <div class="active" id="Death Knight" dataclass="Death Knight">
                                                                    <input id="{{$fguild->character->name}}" name="character_name[]" value="{{$fguild->character->name}}" type="checkbox"> <span class="Deathknight">{{$fguild->character->name}}</span>
                                                                </div>
                                                            @else
                                                            @endif
                                                        @elseif($fguild->character->class == 7)
                                                            @if($_GET['class'] == 'Shaman')
                                                                <div class="active" id="Shaman" dataclass="Shaman">
                                                                    <input id="{{$fguild->character->name}}" name="character_name[]" value="{{$fguild->character->name}}" type="checkbox"> <span class="Shaman">{{$fguild->character->name}}</span>
                                                                </div>
                                                            @else
                                                            @endif
                                                        @elseif($fguild->character->class == 8)
                                                            @if($_GET['class'] == 'Mage')
                                                                <div class="active" id="Mage" dataclass="Mage">
                                                                    <input id="{{$fguild->character->name}}" name="character_name[]" value="{{$fguild->character->name}}" type="checkbox"> <span class="Mage">{{$fguild->character->name}}</span>
                                                                </div>
                                                            @else
                                                            @endif
                                                        @elseif($fguild->character->class == 9)
                                                            @if($_GET['class'] == 'Warlock')
                                                                <div class="active" id="Warlock" dataclass="Warlock">
                                                                    <input id="{{$fguild->character->name}}" name="character_name[]" value="{{$fguild->character->name}}" type="checkbox"> <span class="Warlock">{{$fguild->character->name}}</span>
                                                                </div>
                                                            @else
                                                            @endif
                                                        @elseif($fguild->character->class == 10)
                                                            @if($_GET['class'] == 'Monk')
                                                                <div class="active" id="Monk" dataclass="Monk">
                                                                    <input id="{{$fguild->character->name}}" name="character_name[]" value="{{$fguild->character->name}}" type="checkbox"> <span class="Monk">{{$fguild->character->name}}</span>
                                                                </div>
                                                            @else
                                                            @endif
                                                        @elseif($fguild->character->class == 11)
                                                            @if($_GET['class'] == 'Druid')
                                                                <div class="active" id="Druid" dataclass="Druid">
                                                                    <input id="{{$fguild->character->name}}" name="character_name[]" value="{{$fguild->character->name}}" type="checkbox"> <span class="Druid">{{$fguild->character->name}}</span>
                                                                </div>
                                                            @else
                                                            @endif
                                                        @elseif($fguild->character->class == 12)
                                                            @if($_GET['class'] == 'Demon Hunter')
                                                                <div class="active" id="Demon Hunter" dataclass="Demon Hunter">
                                                                    <input id="{{$fguild->character->name}}" name="character_name[]" value="{{$fguild->character->name}}" type="checkbox"> <span class="Demonhunter">{{$fguild->character->name}}</span>
                                                                </div>
                                                            @else
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                @else
                                                @endif
                                                </div>
                                                    </div>
                                                <input type="hidden" name="_token" value="{{Session::token()}}">
                                                <div class="buttons">
                                                    <div class="form-group">
                                                        <button onSubmit="return check()" type="submit" class="primary button">
                                                <span class="js-login-text">
                                                    create static
                                                </span>
                                                        </button>
                                                    </div>
                                                </div>
                                            @else
                                            @endif
                                        </div>
                                    </div>
                                </form>

                                @else
                                Please connect battle.net account
                                @endif
                        @elseif($menuFilter->menu_name == 'Battle.net account')
                            <form target="_blank" method="get" action="{{route('battlenet.oauth' , \App\User::find(Auth::user()->id)->lang)}}">
                                <div id="battlenet">
                                    <div class="region">
                                        @if(count($user->battlenet_token) > 0)
                                            @if($check_token->exp >= time())
                                                <label for="region" class="control-label">Change you'r region</label>
                                            @else
                                                <label for="region" class="control-label">You'r region</label>
                                            @endif
                                        @else
                                            <label for="region" class="control-label">Select you'r region</label>
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
                                                <button type="submit" style="width: 71px;height: 32px;" class="primary button">
                                                    <span style="line-height: 0px !important;" class="js-login-text">
                                                        @if(count($user->battlenet_token) > 0)
                                                            @if($check_token->exp >= time())
                                                                Change
                                                            @else
                                                                Bind
                                                            @endif
                                                        @else
                                                            Login
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
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="_token" value="{{Session::token()}}">
                            </form>
                            <div>
                                @if(count($user->battlenet_token) > 0)
                                    @if($check_token->exp >= time())
                                       hello {{$battlenetresponse->battletag}} with id {{$battlenetresponse->id}}
                                    @else
                                    @endif
                                @else
                                @endif
                            </div>
                        @endif
                    </div>

                </div>
    <!-- popup-1 -->
    <a href="#x" class="overlay" id="win1"></a>
    <div class="popup">
        @if(count($usercharacters) > 0)
            <div onClick="$('.showNoti').toggle()">
                <span style="color: red">{{count($usercharacters)}}</span> new notifications
            </div>
            <div class="showNoti" style="display: none">
                @foreach($usercharacters as $usercharacter)
                    <a href="{{route('mark.asread',$usercharacter->id)}}">
                        <li>You're character: {{$usercharacter->battlenet_user_character_name}} invited to this static: {{\App\WowStatic::find($usercharacter->static_id)->static_name}}</li>
                    </a>
                @endforeach
            </div>
        @else
        @endif
        <a class="close" title="Закрыть" href="#close"></a>
    </div>


</content>
<footer>
    WoW<span style="color:red; font-weight: 600; font-size: 15px;">R</span>aid
</footer>
</body>
<script src="/js/profile/checkform.js"></script>
<script src="/js/profile/selectcharacter.js"></script>
<script src="/js/menu/menu.js"></script>
<script src="/js/profile/classie.js"></script>
<script src="/js/profile/gnmenu.js"></script>
<script>
    new gnMenu(document.getElementById('gn-menu'));
</script>
</html>