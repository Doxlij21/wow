<!doctype html>
<html style="min-width: 1410px; background-color: #69797e;">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="initial-scale=1.0001, minimum-scale=0.7, user-scalable=yes"/>
    <script src="/js/jquery-3.2.1.min.js"></script>
    @extends('css.profilecss')
    <script src="/js/login/loginWrap.js"></script>
    <script src="/js/login/login.js"></script>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
</head>
<body>
<div class="full-wrap">
    <div id="headerMover">
        <header>
        </header>
        <div id="content" class="indexNews">
            <div class="pageWidth">
                <div class="pageContent">
                    <div style="float:left;height: 500px;width: 150px;" id="profileMenu">
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
                    <div style="float: left;width: 1060px;" id="profileContent">
                        @if($menuFilter->menu_name == 'Create static')
                            @if(count($user->battlenet_token) > 0)
                                <form class="form" action="{{route('profile.create.static')}}" enctype="multipart/form-data" onSubmit="return check()">
                                    <div id="static" style="float: left;">
                                        <div class="staticTitle">
                                            <label for="static_name">Chose static title</label>
                                            <input id="static_name" type="text" name="static_name">
                                        </div>
                                        <div class="staticCharacter">
                                            <label for="staticCharacter">Select you'r character</label>
                                            <ul id="staticCharacterOpt">
                                                @foreach($wowresponse->characters as $wowr)
                                                    @if($wowr->level == 110)
                                                        <li style="cursor: pointer">{{$wowr->name}} , {{$wowr->realm}} <img src="https://render-eu.worldofwarcraft.com/character/{{$wowr->thumbnail}}"></li>
                                                        <div id="transferSelectedCharacter" style="display: none">
                                                            <div>
                                                                You selected this character: {{$wowr->name}} , {{$wowr->realm}} <img src="https://render-eu.worldofwarcraft.com/character/{{$wowr->thumbnail}}">
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
                                                <div id="classFilterWrap">
                                                    <ul id="classFilter">
                                                        <li class="" data-cat-class="All">All</li>
                                                        <li class="" data-cat-class="Warrior"><span style="color: #C79C6E;">Warrior</span></li>
                                                        <li class="" data-cat-class="Paladin"><span style="color: #F58CBA">Paladin</span></li>
                                                        <li class="" data-cat-class="Hunter">Hunter</li>
                                                        <li class="" data-cat-class="Rogue">Rogue</li>
                                                        <li class="" data-cat-class="Priest">Priest</li>
                                                        <li class="" data-cat-class="Death Knight">Death Knight</li>
                                                        <li class="" data-cat-class="Shaman">Shaman</li>
                                                        <li class="" data-cat-class="Mage">Mage</li>
                                                        <li class="" data-cat-class="Warlock">Warlock</li>
                                                        <li class="" data-cat-class="Monk">Monk</li>
                                                        <li class="" data-cat-class="Druid">Druid</li>
                                                        <li class="" data-cat-class="Demon Hunter">Demon Hunter</li>
                                                    </ul>
                                                </div>
                                                <div id="selectCharacters">
                                                @if(count(request()->class) > 0)
                                                    @foreach($filteredguild as $fguild)
                                                            @if($_GET['class'] == 'All')
                                                                <div>
                                                                    <input id="{{$fguild->character->name}}" name="character_name[]" value="{{$fguild->character->name}}" type="checkbox">{{$fguild->character->name}}
                                                                </div>
                                                            @else
                                                            @endif
                                                        @if($fguild->character->class == 1)
                                                            @if($_GET['class'] == 'Warrior')
                                                                <div class="active" id="Warrior" dataclass="Warrior">
                                                                    <input id="{{$fguild->character->name}}" name="character_name[]" value="{{$fguild->character->name}}" type="checkbox"> <span style="color: #C79C6E;">{{$fguild->character->name}}</span>
                                                                </div>
                                                            @else
                                                            @endif
                                                        @elseif($fguild->character->class == 2)
                                                            @if($_GET['class'] == 'Paladin')
                                                                <div class="active" id="Paladin" dataclass="Paladin">
                                                                    <input id="{{$fguild->character->name}}" name="character_name[]" value="{{$fguild->character->name}}" type="checkbox"> <span style="color: #F58CBA">{{$fguild->character->name}}</span>
                                                                </div>
                                                            @else
                                                            @endif
                                                        @elseif($fguild->character->class == 3)
                                                            @if($_GET['class'] == 'Hunter')
                                                                <div class="active" id="Hunter" dataclass="Hunter">
                                                                    <input id="{{$fguild->character->name}}" name="character_name[]" value="{{$fguild->character->name}}" type="checkbox"> {{$fguild->character->name}}
                                                                </div>
                                                            @else
                                                            @endif
                                                        @elseif($fguild->character->class == 4)
                                                            @if($_GET['class'] == 'Rogue')
                                                                <div class="active" id="Rogue" dataclass="Rogue">
                                                                    <input id="{{$fguild->character->name}}" name="character_name[]" value="{{$fguild->character->name}}" type="checkbox"> {{$fguild->character->name}}
                                                                </div>
                                                            @else
                                                            @endif
                                                        @elseif($fguild->character->class == 5)
                                                            @if($_GET['class'] == 'Priest')
                                                                <div class="active" id="Priest" dataclass="Priest">
                                                                    <input id="{{$fguild->character->name}}" name="character_name[]" value="{{$fguild->character->name}}" type="checkbox"> {{$fguild->character->name}}
                                                                </div>
                                                            @else
                                                            @endif
                                                        @elseif($fguild->character->class == 6)
                                                            @if($_GET['class'] == 'Death Knight')
                                                                <div class="active" id="Death Knight" dataclass="Death Knight">
                                                                    <input id="{{$fguild->character->name}}" name="character_name[]" value="{{$fguild->character->name}}" type="checkbox"> {{$fguild->character->name}}
                                                                </div>
                                                            @else
                                                            @endif
                                                        @elseif($fguild->character->class == 7)
                                                            @if($_GET['class'] == 'Shaman')
                                                                <div class="active" id="Shaman" dataclass="Shaman">
                                                                    <input id="{{$fguild->character->name}}" name="character_name[]" value="{{$fguild->character->name}}" type="checkbox"> {{$fguild->character->name}}
                                                                </div>
                                                            @else
                                                            @endif
                                                        @elseif($fguild->character->class == 8)
                                                            @if($_GET['class'] == 'Mage')
                                                                <div class="active" id="Mage" dataclass="Mage">
                                                                    <input id="{{$fguild->character->name}}" name="character_name[]" value="{{$fguild->character->name}}" type="checkbox"> {{$fguild->character->name}}
                                                                </div>
                                                            @else
                                                            @endif
                                                        @elseif($fguild->character->class == 9)
                                                            @if($_GET['class'] == 'Warlock')
                                                                <div class="active" id="Warlock" dataclass="Warlock">
                                                                    <input id="{{$fguild->character->name}}" name="character_name[]" value="{{$fguild->character->name}}" type="checkbox"> {{$fguild->character->name}}
                                                                </div>
                                                            @else
                                                            @endif
                                                        @elseif($fguild->character->class == 10)
                                                            @if($_GET['class'] == 'Monk')
                                                                <div class="active" id="Monk" dataclass="Monk">
                                                                    <input id="{{$fguild->character->name}}" name="character_name[]" value="{{$fguild->character->name}}" type="checkbox"> {{$fguild->character->name}}
                                                                </div>
                                                            @else
                                                            @endif
                                                        @elseif($fguild->character->class == 11)
                                                            @if($_GET['class'] == 'Druid')
                                                                <div class="active" id="Druid" dataclass="Druid">
                                                                    <input id="{{$fguild->character->name}}" name="character_name[]" value="{{$fguild->character->name}}" type="checkbox"> {{$fguild->character->name}}
                                                                </div>
                                                            @else
                                                            @endif
                                                        @elseif($fguild->character->class == 12)
                                                            @if($_GET['class'] == 'Demon Hunter')
                                                                <div class="active" id="Demon Hunter" dataclass="Demon Hunter">
                                                                    <input id="{{$fguild->character->name}}" name="character_name[]" value="{{$fguild->character->name}}" type="checkbox"> {{$fguild->character->name}}
                                                                </div>
                                                            @else
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                @else
                                                @endif
                                                </div>
                                                <input type="hidden" name="_token" value="{{Session::token()}}">
                                                <div class="buttons" style="padding: 20px 0;border-top: 1px solid #dad8de;width: 100%;text-align: center;">
                                                    <div class="form-group">
                                                        <button onSubmit="return check()" type="submit" style="width: 71px;height: 32px;" class="primary button">
                                                <span style="line-height: 0px !important;" class="js-login-text">
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
                                <div style="float: right;width: 240.844px;margin-left: 5px;" id="staticHelper">
                                    <div style="position: fixed;height: auto;margin: 0 auto;" class="helperWrap">
                                        <div style="width: 240.844px;" class="first">
                                            <span class="pending">Choose you'r static name <a href="#static_name"><i class="fa fa-hand-pointer-o" aria-hidden="true"></i></a></span>
                                            <span style="color: green;display: none" class="done"></span>
                                            <span style="color: red;display: none" class="error"></span>
                                        </div>
                                        <div style="width: 240.844px;" class="second">
                                            <span class="pending">Choose static rl<a href="#staticCharacterOpt"><i class="fa fa-hand-pointer-o" aria-hidden="true"></i></a></span>
                                            <span style="color: green;display: none" class="done"></span>
                                        </div>
                                        <div style="width: 240.844px;" class="third">
                                            <span class="pending">Select static members:</span>
                                            <span style="color: green;display: none" class="done">Selected static members:</span>
                                            <span style="color: red;display: none" class="error"></span>
                                        </div>
                                    </div>
                                </div>
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
            </div>
        </div>
    </div>
    <div id="overlays"></div>
</div>
<footer>
</footer>
</body>
<script src="/js/profile/checkform.js"></script>
<script src="/js/profile/selectcharacter.js"></script>
<script src="/js/menu/menu.js"></script>
</html>