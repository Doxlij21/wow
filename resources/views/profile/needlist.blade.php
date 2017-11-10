<!doctype html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="initial-scale=1.0001, minimum-scale=0.7, user-scalable=yes"/>
    <script src="/js/jquery-3.2.1.min.js"></script>
    <script src="/js/profile/needlist/postneedlist.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="/js/profile/needlist/dragandsort.js"></script>
    <?php
        if (\App\User::find(\Illuminate\Support\Facades\Auth::user()->id)->username == 'raidtest')
        {
            $charstats = \App\User::join('battlenet_user_characters' , 'battlenet_user_characters.battlenet_user_character_user_id' , '=' , 'users.id')
                ->join('simc','simc.simc_char','=','battlenet_user_characters.battlenet_user_character_name')
                ->where('simc.simc_char','Некрва')
                ->where('simc.user_id','10')
                ->get()
                ->last();
            $charequip = \App\charEquippedItems::where('char_name','Ронуда')->first();
            $charsimcitem = \App\SimcItem::where('simc_char','Ронуда')->get();
        } else {
            if (count(request()->char)>0)
            {
                $charstats = \App\User::join('battlenet_user_characters' , 'battlenet_user_characters.battlenet_user_character_user_id' , '=' , 'users.id')
                    ->join('simc','simc.simc_char','=','battlenet_user_characters.battlenet_user_character_name')
                    ->where('simc.simc_char',$_GET['char'])
                    ->where('simc.user_id',Auth::user()->id)
                    ->get()
                    ->last();
                $charequip = \App\charEquippedItems::where('char_name',$_GET['char'])->where('user_id',\Illuminate\Support\Facades\Auth::user()->id)->first();
                $charsimcitem = \App\SimcItem::where('simc_char',$_GET['char'])->where('user_id',\Illuminate\Support\Facades\Auth::user()->id)->get();

                $switcheditemhead = \App\NeedlistSwitcher::where('user_char',$_GET['char'])->where('user_item_inventory_type','1')->where('user_id',\Illuminate\Support\Facades\Auth::user()->id)->get()->last();
                $switcheditemneck = \App\NeedlistSwitcher::where('user_char',$_GET['char'])->where('user_item_inventory_type','2')->where('user_id',\Illuminate\Support\Facades\Auth::user()->id)->get()->last();
                $switcheditemshoulder = \App\NeedlistSwitcher::where('user_char',$_GET['char'])->where('user_item_inventory_type','3')->where('user_id',\Illuminate\Support\Facades\Auth::user()->id)->get()->last();
                $capeids = ['4','16'];
                $switcheditemback = \App\NeedlistSwitcher::where('user_char',$_GET['char'])->where('user_id',\Illuminate\Support\Facades\Auth::user()->id)->whereIn('user_item_inventory_type',$capeids)->get()->last();
                $chestids = ['5','20'];
                $switcheditemchest = \App\NeedlistSwitcher::where('user_char',$_GET['char'])->where('user_id',\Illuminate\Support\Facades\Auth::user()->id)->whereIn('user_item_inventory_type',$chestids)->get()->last();
                $switcheditembelt = \App\NeedlistSwitcher::where('user_char',$_GET['char'])->where('user_item_inventory_type','6')->where('user_id',\Illuminate\Support\Facades\Auth::user()->id)->get()->last();
                $switcheditempants = \App\NeedlistSwitcher::where('user_char',$_GET['char'])->where('user_item_inventory_type','7')->where('user_id',\Illuminate\Support\Facades\Auth::user()->id)->get()->last();
                $switcheditemfeet = \App\NeedlistSwitcher::where('user_char',$_GET['char'])->where('user_item_inventory_type','8')->where('user_id',\Illuminate\Support\Facades\Auth::user()->id)->get()->last();
                $switcheditembracers = \App\NeedlistSwitcher::where('user_char',$_GET['char'])->where('user_item_inventory_type','9')->where('user_id',\Illuminate\Support\Facades\Auth::user()->id)->get()->last();
                $switcheditemgloves = \App\NeedlistSwitcher::where('user_char',$_GET['char'])->where('user_item_inventory_type','10')->where('user_id',\Illuminate\Support\Facades\Auth::user()->id)->get()->last();

                $progressionNH = \App\CharProgression::where('user_char',$_GET['char'])->where('user_id',\Illuminate\Support\Facades\Auth::user()->id)->where('user_raid','The Nighthold')->first();
                $progressionTOS = \App\CharProgression::where('user_char',$_GET['char'])->where('user_id',\Illuminate\Support\Facades\Auth::user()->id)->where('user_raid','Tomb of Sargeras')->first();
                $progressionATBT = \App\CharProgression::where('user_char',$_GET['char'])->where('user_id',\Illuminate\Support\Facades\Auth::user()->id)->where('user_raid','Antorus the burning throne')->first();

                $raidtemplates = \App\CharRaidTemplates::where('user_char',$_GET['char'])->get();
            } else {}
        }
    ?>
</head>

@if (\App\User::find(\Illuminate\Support\Facades\Auth::user()->id)->username == 'raidtest')
    <form id="statsform" method="POST" action="{{route('profile.needlist.update.test.stats')}}" enctype="multipart/form-data">
        <div>
            select character:
            <select name="selectcharacter" id="selectCharacter">
                @if (count(request()->char)>0)
                    <option>{{request()->char}}</option>
                    @foreach(Auth::user()->characters as $characterstats)
                        @if(request()->char == $characterstats->battlenet_user_character_name)
                        @else
                            <option value="{{$characterstats->battlenet_user_character_name}}">{{$characterstats->battlenet_user_character_name}}</option>
                        @endif
                    @endforeach
                @else
                    <option></option>
                    @foreach(Auth::user()->characters as $characterstats)
                        <option value="{{$characterstats->battlenet_user_character_name}}">{{$characterstats->battlenet_user_character_name}}</option>
                    @endforeach
                @endif
            </select>
        </div>
        {{ csrf_field() }}
    </form>
@else
    <form id="statsform" method="POST" action="{{route('profile.needlist.update.stats')}}" enctype="multipart/form-data">
        <div>
            select character:
            <select name="selectcharacter" id="selectCharacter">
                @if (count(request()->char)>0)
                    <option>{{request()->char}}</option>
                    @foreach(Auth::user()->characters as $characterstats)
                        @if(request()->char == $characterstats->battlenet_user_character_name)
                        @else
                            <option value="{{$characterstats->battlenet_user_character_name}}|{{$characterstats->battlenet_user_character_realm}}">{{$characterstats->battlenet_user_character_name}}</option>
                        @endif
                    @endforeach
                @else
                    <option></option>
                    @foreach(Auth::user()->characters as $characterstats)
                        <option value="{{$characterstats->battlenet_user_character_name}}|{{$characterstats->battlenet_user_character_realm}}">{{$characterstats->battlenet_user_character_name}}</option>
                    @endforeach
                @endif
            </select>
        </div>
        {{ csrf_field() }}
    </form>
@endif
<div id="charinveq" style="float: right;width: 500px;">
    <?php
        if (count(request()->tempname))
        {
            $tempname = \App\CharRaidTemplates::where('id',request()->tempname)->firstOrFail();
            $explodedtempname[] = [explode(',',$tempname->user_item_inventory_type),explode(',',$tempname->user_item_id),explode(',',$tempname->user_item_icon)];
        } else {}
    ?>
    <div style="float: left">
        <div id="left-items">
            <div id="left-item-head">
                @if(request()->tempname)
                    @foreach($explodedtempname[0][0] as $key => $tempn)
                        @if($tempn == '1')
                            <span style="background: blue;" id="1" data-tooltip-href="http://www.wowdb.com/items/{{$explodedtempname[0][1][$key]}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$explodedtempname[0][2][$key]}}.jpg"></span>
                        @else
                            <?php $search_key = array_search('1', $explodedtempname[0][0]); ?>
                            @if($key == $search_key)
                                @if(count($switcheditemhead)>0)
                                    @if($switcheditemhead->needlist_switcher == '1')
                                        <span style="background: green;" id="1" data-tooltip-href="http://www.wowdb.com/items/{{$switcheditemhead->user_item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$switcheditemhead->user_item_icon}}.jpg"></span>
                                    @else
                                        <span style="background: red;" id="1" data-tooltip-href="http://www.wowdb.com/items/{{$charequip->head_id}}?itemLevel={{$charequip->head_ilvl}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$charequip->head_icon}}.jpg"></span>
                                    @endif
                                @else
                                    <span style="background: red;" id="1" data-tooltip-href="http://www.wowdb.com/items/{{$charequip->head_id}}?itemLevel={{$charequip->head_ilvl}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$charequip->head_icon}}.jpg"></span>
                                @endif
                            @else
                            @endif
                        @endif
                    @endforeach
                @else
                    @if(count($switcheditemhead)>0)
                        @if($switcheditemhead->needlist_switcher == '1')
                            <span style="background: green;" id="1" data-tooltip-href="http://www.wowdb.com/items/{{$switcheditemhead->user_item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$switcheditemhead->user_item_icon}}.jpg"></span>
                        @else
                            <span style="background: red;" id="1" data-tooltip-href="http://www.wowdb.com/items/{{$charequip->head_id}}?itemLevel={{$charequip->head_ilvl}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$charequip->head_icon}}.jpg"></span>
                        @endif
                    @else
                        <span style="background: red;" id="1" data-tooltip-href="http://www.wowdb.com/items/{{$charequip->head_id}}?itemLevel={{$charequip->head_ilvl}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$charequip->head_icon}}.jpg"></span>
                    @endif
                @endif
            </div>
            <div id="left-item-neck">
                @if(request()->tempname)
                    @foreach($explodedtempname[0][0] as $key => $tempn)
                        @if($tempn == '2')
                            <span style="background: blue;" id="2" data-tooltip-href="http://www.wowdb.com/items/{{$explodedtempname[0][1][$key]}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$explodedtempname[0][2][$key]}}.jpg"></span>
                        @else
                            <?php $search_key = array_search('2', $explodedtempname[0][0]); ?>
                            @if($key == $search_key)
                                @if(count($switcheditemneck)>0)
                                    @if($switcheditemneck->needlist_switcher == '1')
                                        <span style="background: green;" id="2" data-tooltip-href="http://www.wowdb.com/items/{{$switcheditemneck->user_item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$switcheditemneck->user_item_icon}}.jpg"></span>
                                    @else
                                        <span style="background: red;" id="2" data-tooltip-href="http://www.wowdb.com/items/{{$charequip->neck_id}}?itemLevel={{$charequip->neck_ilvl}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$charequip->neck_icon}}.jpg"></span>
                                    @endif
                                @else
                                        <span style="background: red;" id="2" data-tooltip-href="http://www.wowdb.com/items/{{$charequip->neck_id}}?itemLevel={{$charequip->neck_ilvl}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$charequip->neck_icon}}.jpg"></span>
                                @endif
                            @else
                            @endif
                        @endif
                    @endforeach
                @else
                    @if(count($switcheditemneck)>0)
                        @if($switcheditemneck->needlist_switcher == '1')
                            <span style="background: green;" id="2" data-tooltip-href="http://www.wowdb.com/items/{{$switcheditemneck->user_item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$switcheditemneck->user_item_icon}}.jpg"></span>
                        @else
                            <span style="background: red;" id="2" data-tooltip-href="http://www.wowdb.com/items/{{$charequip->neck_id}}?itemLevel={{$charequip->neck_ilvl}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$charequip->neck_icon}}.jpg"></span>
                        @endif
                    @else
                        <span style="background: red;" id="2" data-tooltip-href="http://www.wowdb.com/items/{{$charequip->neck_id}}?itemLevel={{$charequip->neck_ilvl}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$charequip->neck_icon}}.jpg"></span>
                    @endif
                @endif
            </div>
            <div id="left-item-shoulders">
                @if(request()->tempname)
                    @foreach($explodedtempname[0][0] as $key => $tempn)
                        @if($tempn == '3')
                            <span style="background: blue;" id="3" data-tooltip-href="http://www.wowdb.com/items/{{$explodedtempname[0][1][$key]}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$explodedtempname[0][2][$key]}}.jpg"></span>
                        @else
                            <?php $search_key = array_search('3', $explodedtempname[0][0]); ?>
                            @if($key == $search_key)
                                @if(count($switcheditemshoulder)>0)
                                    @if($switcheditemshoulder->needlist_switcher == '1')
                                        <span style="background: green;" id="3" data-tooltip-href="http://www.wowdb.com/items/{{$switcheditemshoulder->user_item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$switcheditemshoulder->user_item_icon}}.jpg"></span>
                                    @else
                                        <span style="background: red;" id="3" data-tooltip-href="http://www.wowdb.com/items/{{$charequip->shoulder_id}}?itemLevel={{$charequip->shoulder_ilvl}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$charequip->shoulder_icon}}.jpg"></span>
                                    @endif
                                @else
                                    <span style="background: red;" id="3" data-tooltip-href="http://www.wowdb.com/items/{{$charequip->shoulder_id}}?itemLevel={{$charequip->shoulder_ilvl}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$charequip->shoulder_icon}}.jpg"></span>
                                @endif
                            @else
                            @endif
                        @endif
                    @endforeach
                @else
                    @if(count($switcheditemshoulder)>0)
                        @if($switcheditemshoulder->needlist_switcher == '1')
                            <span style="background: green;" id="3" data-tooltip-href="http://www.wowdb.com/items/{{$switcheditemshoulder->user_item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$switcheditemshoulder->user_item_icon}}.jpg"></span>
                        @else
                            <span style="background: red;" id="3" data-tooltip-href="http://www.wowdb.com/items/{{$charequip->shoulder_id}}?itemLevel={{$charequip->shoulder_ilvl}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$charequip->shoulder_icon}}.jpg"></span>
                        @endif
                    @else
                        <span style="background: red;" id="3" data-tooltip-href="http://www.wowdb.com/items/{{$charequip->shoulder_id}}?itemLevel={{$charequip->shoulder_ilvl}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$charequip->shoulder_icon}}.jpg"></span>
                    @endif
                @endif
            </div>
            <div id="left-item-cloak">
                @if(request()->tempname)
                    @foreach($explodedtempname[0][0] as $key => $tempn)
                        @if($tempn == '4'||$tempn =='16')
                            <span style="background: blue;" id="4" data-tooltip-href="http://www.wowdb.com/items/{{$explodedtempname[0][1][$key]}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$explodedtempname[0][2][$key]}}.jpg"></span>
                        @else
                            <?php $search_key = array_search('4'||'16', $explodedtempname[0][0]); ?>
                            @if($key == $search_key)
                                @if(count($switcheditemback)>0)
                                    @if($switcheditemback->needlist_switcher == '1')
                                        <span style="background: green" id="4" data-tooltip-href="http://www.wowdb.com/items/{{$switcheditemback->user_item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$switcheditemback->user_item_icon}}.jpg"></span>
                                    @else
                                        <span style="background: red;" id="4" data-tooltip-href="http://www.wowdb.com/items/{{$charequip->back_id}}?itemLevel={{$charequip->back_ilvl}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$charequip->back_icon}}.jpg"></span>
                                    @endif
                                @else
                                        <span style="background: red;" id="4" data-tooltip-href="http://www.wowdb.com/items/{{$charequip->back_id}}?itemLevel={{$charequip->back_ilvl}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$charequip->back_icon}}.jpg"></span>
                                @endif
                            @else
                            @endif
                        @endif
                    @endforeach
                @else
                    @if(count($switcheditemback)>0)
                        @if($switcheditemback->needlist_switcher == '1')
                            <span style="background: green" id="4" data-tooltip-href="http://www.wowdb.com/items/{{$switcheditemback->user_item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$switcheditemback->user_item_icon}}.jpg"></span>
                        @else
                            <span style="background: red;" id="4" data-tooltip-href="http://www.wowdb.com/items/{{$charequip->back_id}}?itemLevel={{$charequip->back_ilvl}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$charequip->back_icon}}.jpg"></span>
                        @endif
                    @else
                        <span style="background: red;" id="4" data-tooltip-href="http://www.wowdb.com/items/{{$charequip->back_id}}?itemLevel={{$charequip->back_ilvl}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$charequip->back_icon}}.jpg"></span>
                    @endif
                @endif
            </div>
            <div id="left-item-chest">
                @if(request()->tempname)
                    @foreach($explodedtempname[0][0] as $key => $tempn)
                        @if($tempn == '5'||$tempn == '20')
                            <span style="background: blue;" id="5" data-tooltip-href="http://www.wowdb.com/items/{{$explodedtempname[0][1][$key]}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$explodedtempname[0][2][$key]}}.jpg"></span>
                        @else
                            <?php $search_key = array_search('5'||'20', $explodedtempname[0][0]); ?>
                            @if($key == $search_key)
                                @if(count($switcheditemchest)>0)
                                    @if($switcheditemchest->needlist_switcher == '1')
                                        <span style="background: green" id="5" data-tooltip-href="http://www.wowdb.com/items/{{$switcheditemchest->user_item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$switcheditemchest->user_item_icon}}.jpg"></span>
                                    @else
                                        <span style="background: red;" id="5" data-tooltip-href="http://www.wowdb.com/items/{{$charequip->chest_id}}?itemLevel={{$charequip->chest_ilvl}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$charequip->chest_icon}}.jpg"></span>
                                    @endif
                                @else
                                        <span style="background: red;" id="5" data-tooltip-href="http://www.wowdb.com/items/{{$charequip->chest_id}}?itemLevel={{$charequip->chest_ilvl}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$charequip->chest_icon}}.jpg"></span>
                                @endif
                            @else
                            @endif
                        @endif
                    @endforeach
                @else
                    @if(count($switcheditemchest)>0)
                        @if($switcheditemchest->needlist_switcher == '1')
                            <span style="background: green" id="5" data-tooltip-href="http://www.wowdb.com/items/{{$switcheditemchest->user_item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$switcheditemchest->user_item_icon}}.jpg"></span>
                        @else
                            <span style="background: red;" id="5" data-tooltip-href="http://www.wowdb.com/items/{{$charequip->chest_id}}?itemLevel={{$charequip->chest_ilvl}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$charequip->chest_icon}}.jpg"></span>
                        @endif
                    @else
                        <span style="background: red;" id="5" data-tooltip-href="http://www.wowdb.com/items/{{$charequip->chest_id}}?itemLevel={{$charequip->chest_ilvl}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$charequip->chest_icon}}.jpg"></span>
                    @endif
                @endif
            </div>
            <div id="left-item-wrists">
                @if(request()->tempname)
                    @foreach($explodedtempname[0][0] as $key => $tempn)
                        @if($tempn == '9')
                            <span style="background: blue;" id="9" data-tooltip-href="http://www.wowdb.com/items/{{$explodedtempname[0][1][$key]}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$explodedtempname[0][2][$key]}}.jpg"></span>
                        @else
                            <?php $search_key = array_search('9', $explodedtempname[0][0]); ?>
                            @if($key == $search_key)
                                @if(count($switcheditembracers)>0)
                                    @if($switcheditembracers->needlist_switcher == '1')
                                        <span style="background: green" id="9" data-tooltip-href="http://www.wowdb.com/items/{{$switcheditembracers->user_item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$switcheditembracers->user_item_icon}}.jpg"></span>
                                    @else
                                        <span style="background: red;" id="9" data-tooltip-href="http://www.wowdb.com/items/{{$charequip->wrist_id}}?itemLevel={{$charequip->wrist_ilvl}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$charequip->wrist_icon}}.jpg"></span>
                                    @endif
                                @else
                                        <span style="background: red;" id="9" data-tooltip-href="http://www.wowdb.com/items/{{$charequip->wrist_id}}?itemLevel={{$charequip->wrist_ilvl}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$charequip->wrist_icon}}.jpg"></span>
                                @endif
                            @else
                            @endif
                        @endif
                    @endforeach
                @else
                    @if(count($switcheditembracers)>0)
                        @if($switcheditembracers->needlist_switcher == '1')
                            <span style="background: green" id="9" data-tooltip-href="http://www.wowdb.com/items/{{$switcheditembracers->user_item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$switcheditembracers->user_item_icon}}.jpg"></span>
                        @else
                            <span style="background: red;" id="9" data-tooltip-href="http://www.wowdb.com/items/{{$charequip->wrist_id}}?itemLevel={{$charequip->wrist_ilvl}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$charequip->wrist_icon}}.jpg"></span>
                        @endif
                    @else
                        <span style="background: red;" id="9" data-tooltip-href="http://www.wowdb.com/items/{{$charequip->wrist_id}}?itemLevel={{$charequip->wrist_ilvl}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$charequip->wrist_icon}}.jpg"></span>
                    @endif
                @endif
            </div>
        </div>
    </div>
    <div style="float: right">
        <div id="right-items">
            <div id="right-item-hands">
                @if(request()->tempname)
                    @foreach($explodedtempname[0][0] as $key => $tempn)
                        @if($tempn == '10')
                            <span style="background: blue;" id="10" data-tooltip-href="http://www.wowdb.com/items/{{$explodedtempname[0][1][$key]}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$explodedtempname[0][2][$key]}}.jpg"></span>
                        @else
                            <?php $search_key = array_search('10', $explodedtempname[0][0]); ?>
                            @if($key == $search_key)
                                @if(count($switcheditemgloves)>0)
                                    @if($switcheditemgloves->needlist_switcher == '1')
                                        <span style="background: green" id="10" data-tooltip-href="http://www.wowdb.com/items/{{$switcheditemgloves->user_item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$switcheditemgloves->user_item_icon}}.jpg"></span>
                                    @else
                                        <span style="background: red;" id="10" data-tooltip-href="http://www.wowdb.com/items/{{$charequip->hands_id}}?itemLevel={{$charequip->hands_ilvl}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$charequip->hands_icon}}.jpg"></span>
                                    @endif
                                @else
                                        <span style="background: red;" id="10" data-tooltip-href="http://www.wowdb.com/items/{{$charequip->hands_id}}?itemLevel={{$charequip->hands_ilvl}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$charequip->hands_icon}}.jpg"></span>
                                @endif
                            @else
                            @endif
                        @endif
                    @endforeach
                @else
                    @if(count($switcheditemgloves)>0)
                        @if($switcheditemgloves->needlist_switcher == '1')
                            <span style="background: green" id="10" data-tooltip-href="http://www.wowdb.com/items/{{$switcheditemgloves->user_item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$switcheditemgloves->user_item_icon}}.jpg"></span>
                        @else
                            <span style="background: red;" id="10" data-tooltip-href="http://www.wowdb.com/items/{{$charequip->hands_id}}?itemLevel={{$charequip->hands_ilvl}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$charequip->hands_icon}}.jpg"></span>
                        @endif
                    @else
                        <span style="background: red;" id="10" data-tooltip-href="http://www.wowdb.com/items/{{$charequip->hands_id}}?itemLevel={{$charequip->hands_ilvl}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$charequip->hands_icon}}.jpg"></span>
                    @endif
                @endif
            </div>
            <div id="right-item-waist">
                @if(request()->tempname)
                    @foreach($explodedtempname[0][0] as $key => $tempn)
                        @if($tempn == '6')
                            <span style="background: blue;" id="6" data-tooltip-href="http://www.wowdb.com/items/{{$explodedtempname[0][1][$key]}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$explodedtempname[0][2][$key]}}.jpg"></span>
                        @else
                            <?php $search_key = array_search('6', $explodedtempname[0][0]); ?>
                            @if($key == $search_key)
                                @if(count($switcheditembelt)>0)
                                    @if($switcheditembelt->needlist_switcher == '1')
                                        <span style="background: green" id="6" data-tooltip-href="http://www.wowdb.com/items/{{$switcheditembelt->user_item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$switcheditembelt->user_item_icon}}.jpg"></span>
                                    @else
                                        <span style="background: red;" id="6" data-tooltip-href="http://www.wowdb.com/items/{{$charequip->waist_id}}?itemLevel={{$charequip->waist_ilvl}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$charequip->waist_icon}}.jpg"></span>
                                    @endif
                                @else
                                        <span style="background: red;" id="6" data-tooltip-href="http://www.wowdb.com/items/{{$charequip->waist_id}}?itemLevel={{$charequip->waist_ilvl}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$charequip->waist_icon}}.jpg"></span>
                                @endif
                            @else
                            @endif
                        @endif
                    @endforeach
                @else
                    @if(count($switcheditembelt)>0)
                        @if($switcheditembelt->needlist_switcher == '1')
                            <span style="background: green" id="6" data-tooltip-href="http://www.wowdb.com/items/{{$switcheditembelt->user_item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$switcheditembelt->user_item_icon}}.jpg"></span>
                        @else
                            <span style="background: red;" id="6" data-tooltip-href="http://www.wowdb.com/items/{{$charequip->waist_id}}?itemLevel={{$charequip->waist_ilvl}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$charequip->waist_icon}}.jpg"></span>
                        @endif
                    @else
                        <span style="background: red;" id="6" data-tooltip-href="http://www.wowdb.com/items/{{$charequip->waist_id}}?itemLevel={{$charequip->waist_ilvl}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$charequip->waist_icon}}.jpg"></span>
                    @endif
                @endif
            </div>
            <div id="right-item-legs">
                @if(request()->tempname)
                    @foreach($explodedtempname[0][0] as $key => $tempn)
                        @if($tempn == '7')
                            <span style="background: blue;" id="7" data-tooltip-href="http://www.wowdb.com/items/{{$explodedtempname[0][1][$key]}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$explodedtempname[0][2][$key]}}.jpg"></span>
                        @else
                            <?php $search_key = array_search('7', $explodedtempname[0][0]); ?>
                            @if($key == $search_key)
                                @if(count($switcheditempants)>0)
                                    @if($switcheditempants->needlist_switcher == '1')
                                        <span style="background: green" id="7" data-tooltip-href="http://www.wowdb.com/items/{{$switcheditempants->user_item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$switcheditempants->user_item_icon}}.jpg"></span>
                                    @else
                                        <span style="background: red;" id="7" data-tooltip-href="http://www.wowdb.com/items/{{$charequip->legs_id}}?itemLevel={{$charequip->legs_ilvl}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$charequip->legs_icon}}.jpg"></span>
                                    @endif
                                @else
                                        <span style="background: red;" id="7" data-tooltip-href="http://www.wowdb.com/items/{{$charequip->legs_id}}?itemLevel={{$charequip->legs_ilvl}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$charequip->legs_icon}}.jpg"></span>
                                @endif
                            @else
                            @endif
                        @endif
                    @endforeach
                @else
                    @if(count($switcheditempants)>0)
                        @if($switcheditempants->needlist_switcher == '1')
                            <span style="background: green" id="7" data-tooltip-href="http://www.wowdb.com/items/{{$switcheditempants->user_item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$switcheditempants->user_item_icon}}.jpg"></span>
                        @else
                            <span style="background: red;" id="7" data-tooltip-href="http://www.wowdb.com/items/{{$charequip->legs_id}}?itemLevel={{$charequip->legs_ilvl}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$charequip->legs_icon}}.jpg"></span>
                        @endif
                    @else
                        <span style="background: red;" id="7" data-tooltip-href="http://www.wowdb.com/items/{{$charequip->legs_id}}?itemLevel={{$charequip->legs_ilvl}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$charequip->legs_icon}}.jpg"></span>
                    @endif
                @endif
            </div>
            <div id="right-item-feet">
                @if(request()->tempname)
                    @foreach($explodedtempname[0][0] as $key => $tempn)
                        @if($tempn == '8')
                            <span style="background: blue;" id="8" data-tooltip-href="http://www.wowdb.com/items/{{$explodedtempname[0][1][$key]}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$explodedtempname[0][2][$key]}}.jpg"></span>
                        @else
                            <?php $search_key = array_search('8', $explodedtempname[0][0]); ?>
                            @if($key == $search_key)
                                @if(count($switcheditemfeet)>0)
                                    @if($switcheditemfeet->needlist_switcher == '1')
                                        <span style="background: green" id="8" data-tooltip-href="http://www.wowdb.com/items/{{$switcheditemfeet->user_item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$switcheditemfeet->user_item_icon}}.jpg"></span>
                                    @else
                                        <span style="background: red;" id="8" data-tooltip-href="http://www.wowdb.com/items/{{$charequip->feet_id}}?itemLevel={{$charequip->feet_ilvl}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$charequip->feet_icon}}.jpg"></span>
                                    @endif
                                @else
                                        <span style="background: red;" id="8" data-tooltip-href="http://www.wowdb.com/items/{{$charequip->feet_id}}?itemLevel={{$charequip->feet_ilvl}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$charequip->feet_icon}}.jpg"></span>
                                @endif
                            @else
                            @endif
                        @endif
                    @endforeach
                @else
                    @if(count($switcheditemfeet)>0)
                        @if($switcheditemfeet->needlist_switcher == '1')
                            <span style="background: green" id="8" data-tooltip-href="http://www.wowdb.com/items/{{$switcheditemfeet->user_item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$switcheditemfeet->user_item_icon}}.jpg"></span>
                        @else
                            <span style="background: red;" id="8" data-tooltip-href="http://www.wowdb.com/items/{{$charequip->feet_id}}?itemLevel={{$charequip->feet_ilvl}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$charequip->feet_icon}}.jpg"></span>
                        @endif
                    @else
                        <span style="background: red;" id="8" data-tooltip-href="http://www.wowdb.com/items/{{$charequip->feet_id}}?itemLevel={{$charequip->feet_ilvl}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$charequip->feet_icon}}.jpg"></span>
                    @endif
                @endif
            </div>
            <div id="right-item-finger1">
                <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$charequip->finger1_id}}?itemLevel={{$charequip->finger1_ilvl}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$charequip->finger1_icon}}.jpg"></span>
            </div>
            <div id="right-item-finger2">
                <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$charequip->finger2_id}}?itemLevel={{$charequip->finger2_ilvl}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$charequip->finger2_icon}}.jpg"></span>
            </div>
            <div id="right-item-trinket1">
                <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$charequip->trinket1_id}}?itemLevel={{$charequip->trinket1_ilvl}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$charequip->trinket1_icon}}.jpg"></span>
            </div>
            <div id="right-item-trinket2">
                <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$charequip->trinket2_id}}?itemLevel={{$charequip->trinket2_ilvl}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$charequip->trinket2_icon}}.jpg"></span>
            </div>
        </div>
    </div>
    <div><a class="reseteq" href="#">reset equiped items</a></div>
    <div>
        <form id="saveeq" method="POST" action="{{route('profile.needlist.create.raid.items.template',$_GET['char'])}}" enctype="multipart/form-data">
            <lavel for="template_name">Type name for this template</lavel>
            <input name="template_name">
            <div><a onclick="document.getElementById('saveeq').submit();" class="saveeq" href="#">Save template for this character</a></div>
            {{ csrf_field() }}
        </form>
    </div>
    <div>
        Select you'r template
        <select id="selecttemplate">
            @if(request()->tempname)
                <option>{{\App\CharRaidTemplates::where('id',request()->tempname)->firstOrFail()->template_name}}</option>
            @else
                <option></option>
            @endif
            @foreach($raidtemplates as $raidtemplate)
                <option value="{{$raidtemplate->id}}">
                    {{$raidtemplate->template_name}}
                </option>
            @endforeach
        </select>
    </div>
</div>


@if (count(request()->char)>0)
    <div style="">
        <div id="selectedCharacter"></div>
        intellect:
        @if(count($charstats->sint)>0)
            {{$charstats->sint}}
        @elseif(count($charstats->sagi)>0)
            {{$charstats->sagi}}
        @elseif(count($charstats->sstr)>0)
            {{$charstats->sstr}}
        @endif
        mastery: {{$charstats->smastery}}
        haste: {{$charstats->shaste}}
        scrit: {{$charstats->scrit}}
        versability:
        @if(count($charstats->svers)>0)
            {{$charstats->svers}}
        @else
            you have zero versability
        @endif
    </div>
@else
@endif
<div>
    select raid:
    <select id="selectraid">
        @foreach($raids as $raid)
            <option value="{{$raid->raid_id}}">{{$raid->raid_name}}</option>
        @endforeach
    </select>
</div>
<div id="raiditems">
    @if(count(request()->char)>0 && count(request()->raid) > 0)
        @if(count($charsimcitem )>0 && count($charstats)>0)
            <div id="pending">
                @foreach($charsimcitem as $simcitem)
                    @if($_GET['raid'] == $simcitem->simc_raid)
                        @if($simcitem->simc_raid == 'The Nighthold')
                            @if(count($progressionNH)>0)
                                @if($progressionNH->user_mythic > 0 || $progressionNH->char_ilvl > '930')
                                    @if($simcitem->simc_raid_difficulty == 'Mythic')
                                        <span data-tooltip-href="http://www.wowdb.com/items/{{$simcitem->simc_item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$simcitem->simc_item_icon}}.jpg">{{$simcitem->simc_item_name}}</span>.
                                        this item bust you:
                                        <?php
                                        $a = $simcitem->simc_dps / 100;
                                        $b = $simcitem->simc_dps2 - $simcitem->simc_dps;
                                        $difres = $b/$a;
                                        $difdps = $simcitem->simc_dps - $simcitem->simc_dps2;
                                        ?>
                                        @if($difres > 0)
                                            <span style="background: green">{{substr($difres, 0, 5)}}%</span>.
                                            <div>This item will strengthen you: {{$difdps}} dps</div>.
                                        @else
                                            <span style="background: red">{{substr($difres, 0, 5)}}%</span>.
                                            <div>This item will weaken you: {{$difdps}} dps</div>.
                                        @endif
                                    @else
                                    @endif
                                @elseif($progressionNH->user_heroic > 0)
                                    @if($simcitem->simc_raid_difficulty == 'Heroic')
                                        <span data-tooltip-href="http://www.wowdb.com/items/{{$simcitem->simc_item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$simcitem->simc_item_icon}}.jpg">{{$simcitem->simc_item_name}}</span>.
                                        this item bust you:
                                        <?php
                                        $a = $simcitem->simc_dps / 100;
                                        $b = $simcitem->simc_dps2 - $simcitem->simc_dps;
                                        $difres = $b/$a;
                                        $difdps = $simcitem->simc_dps - $simcitem->simc_dps2;
                                        ?>
                                        @if($difres > 0)
                                            <span style="background: green">{{substr($difres, 0, 5)}}%</span>.
                                            <div>This item will strengthen you: {{$difdps}} dps</div>.
                                        @else
                                            <span style="background: red">{{substr($difres, 0, 5)}}%</span>.
                                            <div>This item will weaken you: {{$difdps}} dps</div>.
                                        @endif
                                    @else
                                    @endif
                                @elseif($progressionNH->user_normal > 0)
                                    @if($simcitem->simc_raid_difficulty == 'Normal')
                                        <span data-tooltip-href="http://www.wowdb.com/items/{{$simcitem->simc_item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$simcitem->simc_item_icon}}.jpg">{{$simcitem->simc_item_name}}</span>.
                                        this item bust you:
                                        <?php
                                        $a = $simcitem->simc_dps / 100;
                                        $b = $simcitem->simc_dps2 - $simcitem->simc_dps;
                                        $difres = $b/$a;
                                        $difdps = $simcitem->simc_dps - $simcitem->simc_dps2;
                                        ?>
                                        @if($difres > 0)
                                            <span style="background: green">{{substr($difres, 0, 5)}}%</span>.
                                            <div>This item will strengthen you: {{$difdps}} dps</div>.
                                        @else
                                            <span style="background: red">{{substr($difres, 0, 5)}}%</span>.
                                            <div>This item will weaken you: {{$difdps}} dps</div>.
                                        @endif
                                    @else
                                    @endif
                                @else
                                @endif
                            @else
                            @endif
                        @elseif($simcitem->simc_raid == 'Tomb of Sargeras')
                            @if(count($progressionTOS)>0)
                                @if($progressionTOS->user_mythic > 0 || $progressionTOS->char_ilvl > '955')
                                    @if($simcitem->simc_raid_difficulty == 'Mythic')
                                        <span data-tooltip-href="http://www.wowdb.com/items/{{$simcitem->simc_item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$simcitem->simc_item_icon}}.jpg">{{$simcitem->simc_item_name}}</span>.
                                        this item bust you:
                                        <?php
                                        $a = $simcitem->simc_dps / 100;
                                        $b = $simcitem->simc_dps2 - $simcitem->simc_dps;
                                        $difres = $b/$a;
                                        $difdps = $simcitem->simc_dps - $simcitem->simc_dps2;
                                        ?>
                                        @if($difres > 0)
                                            <span style="background: green">{{substr($difres, 0, 5)}}%</span>.
                                            <div>This item will strengthen you: {{$difdps}} dps</div>.
                                        @else
                                            <span style="background: red">{{substr($difres, 0, 5)}}%</span>.
                                            <div>This item will weaken you: {{$difdps}} dps</div>.
                                        @endif
                                    @else
                                    @endif
                                @elseif($progressionTOS->user_heroic > 0)
                                    @if($simcitem->simc_raid_difficulty == 'Heroic')
                                        <span data-tooltip-href="http://www.wowdb.com/items/{{$simcitem->simc_item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$simcitem->simc_item_icon}}.jpg">{{$simcitem->simc_item_name}}</span>.
                                        this item bust you:
                                        <?php
                                        $a = $simcitem->simc_dps / 100;
                                        $b = $simcitem->simc_dps2 - $simcitem->simc_dps;
                                        $difres = $b/$a;
                                        $difdps = $simcitem->simc_dps - $simcitem->simc_dps2;
                                        ?>
                                        @if($difres > 0)
                                            <span style="background: green">{{substr($difres, 0, 5)}}%</span>.
                                            <div>This item will strengthen you: {{$difdps}} dps</div>.
                                        @else
                                            <span style="background: red">{{substr($difres, 0, 5)}}%</span>.
                                            <div>This item will weaken you: {{$difdps}} dps</div>.
                                        @endif
                                    @else
                                    @endif
                                @elseif($progressionTOS->user_normal > 0)
                                    @if($simcitem->simc_raid_difficulty == 'Normal')
                                        <span data-tooltip-href="http://www.wowdb.com/items/{{$simcitem->simc_item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$simcitem->simc_item_icon}}.jpg">{{$simcitem->simc_item_name}}</span>.
                                        this item bust you:
                                        <?php
                                        $a = $simcitem->simc_dps / 100;
                                        $b = $simcitem->simc_dps2 - $simcitem->simc_dps;
                                        $difres = $b/$a;
                                        $difdps = $simcitem->simc_dps - $simcitem->simc_dps2;
                                        ?>
                                        @if($difres > 0)
                                            <span style="background: green">{{substr($difres, 0, 5)}}%</span>.
                                            <div>This item will strengthen you: {{$difdps}} dps</div>.
                                        @else
                                            <span style="background: red">{{substr($difres, 0, 5)}}%</span>.
                                            <div>This item will weaken you: {{$difdps}} dps</div>.
                                        @endif
                                    @else
                                    @endif
                                @else
                                @endif
                            @else
                            @endif
                        @elseif($simcitem->simc_raid == 'Antorus the burning throne')
                            @if(count($progressionATBT)>0)
                                @if($progressionATBT->user_mythic > 0)
                                    @if($simcitem->simc_raid_difficulty == 'Mythic')
                                        <span data-tooltip-href="http://www.wowdb.com/items/{{$simcitem->simc_item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$simcitem->simc_item_icon}}.jpg">{{$simcitem->simc_item_name}}</span>.
                                        this item bust you:
                                        <?php
                                        $a = $simcitem->simc_dps / 100;
                                        $b = $simcitem->simc_dps2 - $simcitem->simc_dps;
                                        $difres = $b/$a;
                                        $difdps = $simcitem->simc_dps - $simcitem->simc_dps2;
                                        ?>
                                        @if($difres > 0)
                                            <span style="background: green">{{substr($difres, 0, 5)}}%</span>.
                                            <div>This item will strengthen you: {{$difdps}} dps</div>.
                                        @else
                                            <span style="background: red">{{substr($difres, 0, 5)}}%</span>.
                                            <div>This item will weaken you: {{$difdps}} dps</div>.
                                        @endif
                                    @else
                                    @endif
                                @elseif($progressionATBT->user_heroic > 0)
                                    @if($simcitem->simc_raid_difficulty == 'Heroic')
                                        <span data-tooltip-href="http://www.wowdb.com/items/{{$simcitem->simc_item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$simcitem->simc_item_icon}}.jpg">{{$simcitem->simc_item_name}}</span>.
                                        this item bust you:
                                        <?php
                                        $a = $simcitem->simc_dps / 100;
                                        $b = $simcitem->simc_dps2 - $simcitem->simc_dps;
                                        $difres = $b/$a;
                                        $difdps = $simcitem->simc_dps - $simcitem->simc_dps2;
                                        ?>
                                        @if($difres > 0)
                                            <span style="background: green">{{substr($difres, 0, 5)}}%</span>.
                                            <div>This item will strengthen you: {{$difdps}} dps</div>.
                                        @else
                                            <span style="background: red">{{substr($difres, 0, 5)}}%</span>.
                                            <div>This item will weaken you: {{$difdps}} dps</div>.
                                        @endif
                                    @else
                                    @endif
                                @elseif($progressionATBT->user_normal > 0)
                                    @if($simcitem->simc_raid_difficulty == 'Normal')
                                        <span data-tooltip-href="http://www.wowdb.com/items/{{$simcitem->simc_item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$simcitem->simc_item_icon}}.jpg">{{$simcitem->simc_item_name}}</span>.
                                        this item bust you:
                                        <?php
                                        $a = $simcitem->simc_dps / 100;
                                        $b = $simcitem->simc_dps2 - $simcitem->simc_dps;
                                        $difres = $b/$a;
                                        $difdps = $simcitem->simc_dps - $simcitem->simc_dps2;
                                        ?>
                                        @if($difres > 0)
                                            <span style="background: green">{{substr($difres, 0, 5)}}%</span>.
                                            <div>This item will strengthen you: {{$difdps}} dps</div>.
                                        @else
                                            <span style="background: red">{{substr($difres, 0, 5)}}%</span>.
                                            <div>This item will weaken you: {{$difdps}} dps</div>.
                                        @endif
                                    @else
                                    @endif
                                @else
                                @endif
                            @else
                            @endif
                        @else
                        @endif
                    @else
                    @endif
                @endforeach
            </div>
        @else
            <div id="pending">
                nothing selected for comparing
            </div>
        @endif
    @else
    @endif

    <div>
        select item:
        @if(count(request()->raid)>0)
            @if($_GET['raid'] == 'The Nighthold')
                @foreach($nhitems as $nhitem)
                    @if(\App\BattlenetUserCharacters::where('battlenet_user_character_name',request()->char)->first()->battlenet_user_character_class == '9')
                        @if(\App\BattlenetUserCharacters::where('battlenet_user_character_name',request()->char)->first()->battlenet_user_character_class == $nhitem->token_classes)
                            @if($nhitem->inventory_type == '16')
                                <span id="4" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                            @elseif($nhitem->inventory_type == '20'||$nhitem->inventory_type == '5')
                                <span id="5" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                            @endif
                        @elseif($nhitem->item_class == '1')
                            @if(count($nhitem->token_classes)>0)
                            @else
                                @if($nhitem->inventory_type == '1')
                                    <span id="1" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '3')
                                    <span id="3" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '16')
                                    <span id="4" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '5'||$nhitem->inventory_type == '20')
                                    <span id="5" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '6')
                                    <span id="6" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '7')
                                    <span id="7" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '8')
                                    <span id="8" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '9')
                                    <span id="9" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '10')
                                    <span id="10" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @endif
                            @endif
                        {{-- Ranged intellect trinkets --}}
                        @elseif($nhitem->item_id == '140792')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140798')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140800')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140801')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140804')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140809')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140809')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        {{--Rings --}}
                        @elseif($nhitem->item_id == '140906')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140897')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140896')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140895')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        {{--Necks--}}
                        @elseif($nhitem->item_id == '140900')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140899')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140898')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140894')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @endif
                    @elseif(\App\BattlenetUserCharacters::where('battlenet_user_character_name',request()->char)->first()->battlenet_user_character_class == '5')
                        @if(\App\BattlenetUserCharacters::where('battlenet_user_character_name',request()->char)->first()->battlenet_user_character_class == $nhitem->token_classes)
                            <span data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_class == '1')
                            @if(count($nhitem->token_classes)>0)
                            @else
                                @if($nhitem->inventory_type == '1')
                                    <span id="1" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '3')
                                    <span id="3" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '16')
                                    <span id="4" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '5'||$nhitem->inventory_type == '20')
                                    <span id="5" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '6')
                                    <span id="6" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '7')
                                    <span id="7" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '8')
                                    <span id="8" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '9')
                                    <span id="9" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '10')
                                    <span id="10" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @endif
                            @endif
                        {{-- Ranged intellect trinkets --}}
                        @elseif($nhitem->item_id == '140792')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140798')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140800')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140801')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140804')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140809')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140809')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                            {{--Rings --}}
                        @elseif($nhitem->item_id == '140906')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140897')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140896')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140895')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                            {{--Necks--}}
                        @elseif($nhitem->item_id == '140900')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140899')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140898')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140894')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @endif
                    @elseif(\App\BattlenetUserCharacters::where('battlenet_user_character_name',request()->char)->first()->battlenet_user_character_class == '8')
                        @if(\App\BattlenetUserCharacters::where('battlenet_user_character_name',request()->char)->first()->battlenet_user_character_class == $nhitem->token_classes)
                            <span data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_class == '1')
                            @if(count($nhitem->token_classes)>0)
                            @else
                                @if($nhitem->inventory_type == '1')
                                    <span id="1" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '3')
                                    <span id="3" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '16')
                                    <span id="4" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '5'||$nhitem->inventory_type == '20')
                                    <span id="5" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '6')
                                    <span id="6" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '7')
                                    <span id="7" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '8')
                                    <span id="8" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '9')
                                    <span id="9" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '10')
                                    <span id="10" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @endif
                            @endif
                            {{-- Ranged intellect trinkets --}}
                        @elseif($nhitem->item_id == '140792')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140798')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140800')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140801')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140804')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140809')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140809')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                            {{--Rings --}}
                        @elseif($nhitem->item_id == '140906')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140897')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140896')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140895')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                            {{--Necks--}}
                        @elseif($nhitem->item_id == '140900')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140899')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140898')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140894')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                            {{--Healer trinkets--}}
                        @elseif($nhitem->item_id == '140793')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140795')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140803')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140805')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @endif
                    @elseif(\App\BattlenetUserCharacters::where('battlenet_user_character_name',request()->char)->first()->battlenet_user_character_class == '3')
                        @if(\App\BattlenetUserCharacters::where('battlenet_user_character_name',request()->char)->first()->battlenet_user_character_class == $nhitem->token_classes)
                            <span data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_class == '3')
                            @if(count($nhitem->token_classes)>0)
                            @else
                                @if($nhitem->inventory_type == '1')
                                    <span id="1" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '3')
                                    <span id="3" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '16')
                                    <span id="4" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '5'||$nhitem->inventory_type == '20')
                                    <span id="5" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '6')
                                    <span id="6" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '7')
                                    <span id="7" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '8')
                                    <span id="8" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '9')
                                    <span id="9" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '10')
                                    <span id="10" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @endif
                            @endif
                        {{--Capes--}}
                        @elseif($nhitem->item_id == '140855')
                            <span id="16" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140909')
                            <span id="16" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140910')
                            <span id="16" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        {{--Ranged agility trinkets--}}
                        @elseif($nhitem->item_id == '140796')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140798')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        {{--Rings--}}
                        @elseif($nhitem->item_id == '140906')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140897')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140896')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140895')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        {{--Necks--}}
                        @elseif($nhitem->item_id == '140900')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140899')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140898')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140894')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        {{--Mellee agility trinket--}}
                        @elseif($nhitem->item_id == '140808')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140794')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140806')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140802')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @endif
                    @elseif(\App\BattlenetUserCharacters::where('battlenet_user_character_name',request()->char)->first()->battlenet_user_character_class == '7')
                        @if(\App\BattlenetUserCharacters::where('battlenet_user_character_name',request()->char)->first()->battlenet_user_character_class == $nhitem->token_classes)
                            <span data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_class == '3')
                            @if(count($nhitem->token_classes)>0)
                            @else
                                @if($nhitem->inventory_type == '1')
                                    <span id="1" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '3')
                                    <span id="3" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '16')
                                    <span id="4" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '5'||$nhitem->inventory_type == '20')
                                    <span id="5" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '6')
                                    <span id="6" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '7')
                                    <span id="7" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '8')
                                    <span id="8" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '9')
                                    <span id="9" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '10')
                                    <span id="10" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @endif
                            @endif
                                {{--Capes--}}
                        @elseif($nhitem->item_id == '140855')
                            <span id="16" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140909')
                            <span id="16" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140910')
                            <span id="16" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        {{-- Ranged intellect trinkets --}}
                        @elseif($nhitem->item_id == '140792')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140798')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140800')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140801')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140804')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140809')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140809')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        {{--Healer trinkets--}}
                        @elseif($nhitem->item_id == '140793')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140795')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140803')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140805')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        {{--Mellee agility trinket--}}
                        @elseif($nhitem->item_id == '140808')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140794')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140806')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140802')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                            {{--Rings--}}
                        @elseif($nhitem->item_id == '140906')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140897')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140896')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140895')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                            {{--Necks--}}
                        @elseif($nhitem->item_id == '140900')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140899')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140898')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140894')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @endif
                    @elseif(\App\BattlenetUserCharacters::where('battlenet_user_character_name',request()->char)->first()->battlenet_user_character_class == '1')
                        @if(\App\BattlenetUserCharacters::where('battlenet_user_character_name',request()->char)->first()->battlenet_user_character_class == $nhitem->token_classes)
                            <span data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_class == '4')
                            @if(count($nhitem->token_classes)>0)
                            @else
                                @if($nhitem->inventory_type == '1')
                                    <span id="1" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '3')
                                    <span id="3" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '16')
                                    <span id="4" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '5'||$nhitem->inventory_type == '20')
                                    <span id="5" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '6')
                                    <span id="6" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '7')
                                    <span id="7" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '8')
                                    <span id="8" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '9')
                                    <span id="9" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '10')
                                    <span id="10" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @endif
                            @endif
                            {{--Capes--}}
                        @elseif($nhitem->item_id == '140855')
                            <span id="16" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140909')
                            <span id="16" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140910')
                            <span id="16" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        {{-- Melee strength trinkets --}}
                        @elseif($nhitem->item_id == '140796')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140799')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140806')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140808')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140790')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                            {{--Rings--}}
                        @elseif($nhitem->item_id == '140906')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140897')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140896')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140895')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                            {{--Necks--}}
                        @elseif($nhitem->item_id == '140900')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140899')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140898')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140894')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        {{--Tank strength trinkets--}}
                        @elseif($nhitem->item_id == '140789')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140791')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140797')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140807')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @endif
                    @elseif(\App\BattlenetUserCharacters::where('battlenet_user_character_name',request()->char)->first()->battlenet_user_character_class == '2')
                        @if(\App\BattlenetUserCharacters::where('battlenet_user_character_name',request()->char)->first()->battlenet_user_character_class == $nhitem->token_classes)
                            <span data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_class == '4')
                            @if(count($nhitem->token_classes)>0)
                            @else
                                @if($nhitem->inventory_type == '1')
                                    <span id="1" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '3')
                                    <span id="3" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '16')
                                    <span id="4" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '5'||$nhitem->inventory_type == '20')
                                    <span id="5" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '6')
                                    <span id="6" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '7')
                                    <span id="7" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '8')
                                    <span id="8" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '9')
                                    <span id="9" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '10')
                                    <span id="10" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @endif
                            @endif
                            {{--Capes--}}
                        @elseif($nhitem->item_id == '140855')
                            <span id="16" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140909')
                            <span id="16" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140910')
                            <span id="16" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        {{-- Melee strength trinkets --}}
                        @elseif($nhitem->item_id == '140796')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140799')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140806')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140808')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140790')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                            {{--Rings--}}
                        @elseif($nhitem->item_id == '140906')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140897')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140896')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140895')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                            {{--Necks--}}
                        @elseif($nhitem->item_id == '140900')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140899')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140898')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140894')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                            {{--Tank strength trinkets--}}
                        @elseif($nhitem->item_id == '140789')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140791')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140797')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140807')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        {{--Healer trinkets--}}
                        @elseif($nhitem->item_id == '140793')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140795')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140803')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140805')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @endif
                    @elseif(\App\BattlenetUserCharacters::where('battlenet_user_character_name',request()->char)->first()->battlenet_user_character_class == '6')
                        @if(\App\BattlenetUserCharacters::where('battlenet_user_character_name',request()->char)->first()->battlenet_user_character_class == $nhitem->token_classes)
                            <span data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_class == '4')
                            @if(count($nhitem->token_classes)>0)
                            @else
                                @if($nhitem->inventory_type == '1')
                                    <span id="1" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '3')
                                    <span id="3" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '16')
                                    <span id="4" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '5'||$nhitem->inventory_type == '20')
                                    <span id="5" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '6')
                                    <span id="6" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '7')
                                    <span id="7" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '8')
                                    <span id="8" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '9')
                                    <span id="9" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '10')
                                    <span id="10" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @endif
                            @endif
                            {{--Capes--}}
                        @elseif($nhitem->item_id == '140855')
                            <span id="16" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140909')
                            <span id="16" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140910')
                            <span id="16" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                            {{-- Melee strength trinkets --}}
                        @elseif($nhitem->item_id == '140796')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140799')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140806')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140808')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140790')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                            {{--Rings--}}
                        @elseif($nhitem->item_id == '140906')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140897')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140896')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140895')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                            {{--Necks--}}
                        @elseif($nhitem->item_id == '140900')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140899')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140898')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140894')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                            {{--Tank trinkets--}}
                        @elseif($nhitem->item_id == '140789')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140791')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140797')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140807')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @endif
                    @elseif(\App\BattlenetUserCharacters::where('battlenet_user_character_name',request()->char)->first()->battlenet_user_character_class == '4')
                        @if(\App\BattlenetUserCharacters::where('battlenet_user_character_name',request()->char)->first()->battlenet_user_character_class == $nhitem->token_classes)
                            <span data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_class == '2')
                            @if(count($nhitem->token_classes)>0)
                            @else
                                @if($nhitem->inventory_type == '1')
                                    <span id="1" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '3')
                                    <span id="3" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '16')
                                    <span id="4" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '5'||$nhitem->inventory_type == '20')
                                    <span id="5" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '6')
                                    <span id="6" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '7')
                                    <span id="7" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '8')
                                    <span id="8" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '9')
                                    <span id="9" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '10')
                                    <span id="10" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @endif
                            @endif
                            {{--Capes--}}
                        @elseif($nhitem->item_id == '140855')
                            <span id="16" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140909')
                            <span id="16" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140910')
                            <span id="16" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                            {{--Mellee agility trinket--}}
                            @elseif($nhitem->item_id == '140808')
                                <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                            @elseif($nhitem->item_id == '140794')
                                <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                            @elseif($nhitem->item_id == '140806')
                                <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                            @elseif($nhitem->item_id == '140802')
                                <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                            {{--Rings--}}
                        @elseif($nhitem->item_id == '140906')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140897')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140896')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140895')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                            {{--Necks--}}
                        @elseif($nhitem->item_id == '140900')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140899')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140898')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140894')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @endif
                    @elseif(\App\BattlenetUserCharacters::where('battlenet_user_character_name',request()->char)->first()->battlenet_user_character_class == '10')
                        @if(\App\BattlenetUserCharacters::where('battlenet_user_character_name',request()->char)->first()->battlenet_user_character_class == $nhitem->token_classes)
                            <span data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_class == '2')
                            @if(count($nhitem->token_classes)>0)
                            @else
                                @if($nhitem->inventory_type == '1')
                                    <span id="1" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '3')
                                    <span id="3" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '16')
                                    <span id="4" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '5'||$nhitem->inventory_type == '20')
                                    <span id="5" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '6')
                                    <span id="6" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '7')
                                    <span id="7" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '8')
                                    <span id="8" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '9')
                                    <span id="9" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '10')
                                    <span id="10" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @endif
                            @endif
                            {{--Capes--}}
                        @elseif($nhitem->item_id == '140855')
                            <span id="16" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140909')
                            <span id="16" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140910')
                            <span id="16" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        {{--Mellee agility trinket--}}
                        @elseif($nhitem->item_id == '140808')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140794')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140806')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140802')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                            {{--Tank trinkets--}}
                        @elseif($nhitem->item_id == '140789')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140791')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140797')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140807')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                            {{--Healer trinkets--}}
                        @elseif($nhitem->item_id == '140793')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140795')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140803')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140805')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                            {{--Rings--}}
                        @elseif($nhitem->item_id == '140906')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140897')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140896')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140895')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                            {{--Necks--}}
                        @elseif($nhitem->item_id == '140900')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140899')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140898')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140894')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @endif
                    @elseif(\App\BattlenetUserCharacters::where('battlenet_user_character_name',request()->char)->first()->battlenet_user_character_class == '11')
                        @if(\App\BattlenetUserCharacters::where('battlenet_user_character_name',request()->char)->first()->battlenet_user_character_class == $nhitem->token_classes)
                            <span data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_class == '2')
                            @if(count($nhitem->token_classes)>0)
                            @else
                                @if($nhitem->inventory_type == '1')
                                    <span id="1" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '3')
                                    <span id="3" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '16')
                                    <span id="4" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '5'||$nhitem->inventory_type == '20')
                                    <span id="5" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '6')
                                    <span id="6" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '7')
                                    <span id="7" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '8')
                                    <span id="8" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '9')
                                    <span id="9" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '10')
                                    <span id="10" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @endif
                            @endif
                            {{--Capes--}}
                        @elseif($nhitem->item_id == '140855')
                            <span id="16" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140909')
                            <span id="16" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140910')
                            <span id="16" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                            {{--Mellee agility trinket--}}
                        @elseif($nhitem->item_id == '140808')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140794')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140806')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140802')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                            {{--Tank trinkets--}}
                        @elseif($nhitem->item_id == '140789')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140791')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140797')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140807')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                            {{--Healer trinkets--}}
                        @elseif($nhitem->item_id == '140793')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140795')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140803')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140805')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                            {{-- Ranged intellect trinkets --}}
                        @elseif($nhitem->item_id == '140792')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140798')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140800')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140801')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140804')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140809')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140809')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                            {{--Rings--}}
                        @elseif($nhitem->item_id == '140906')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140897')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140896')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140895')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                            {{--Necks--}}
                        @elseif($nhitem->item_id == '140900')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140899')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140898')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140894')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @endif
                    @elseif(\App\BattlenetUserCharacters::where('battlenet_user_character_name',request()->char)->first()->battlenet_user_character_class == '12')
                        @if(\App\BattlenetUserCharacters::where('battlenet_user_character_name',request()->char)->first()->battlenet_user_character_class == $nhitem->token_classes)
                            <span data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_class == '2')
                            @if(count($nhitem->token_classes)>0)
                            @else
                                @if($nhitem->inventory_type == '1')
                                    <span id="1" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '3')
                                    <span id="3" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '16')
                                    <span id="4" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '5'||$nhitem->inventory_type == '20')
                                    <span id="5" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '6')
                                    <span id="6" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '7')
                                    <span id="7" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '8')
                                    <span id="8" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '9')
                                    <span id="9" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @elseif($nhitem->inventory_type == '10')
                                    <span id="10" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                                @endif
                            @endif
                            {{--Capes--}}
                        @elseif($nhitem->item_id == '140855')
                            <span id="16" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140909')
                            <span id="16" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140910')
                            <span id="16" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                            {{--Mellee agility trinket--}}
                        @elseif($nhitem->item_id == '140808')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140794')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140806')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140802')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                            {{--Tank trinkets--}}
                        @elseif($nhitem->item_id == '140789')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140791')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140797')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140807')
                            <span id="12" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                            {{--Rings--}}
                        @elseif($nhitem->item_id == '140906')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140897')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140896')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140895')
                            <span id="11" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                            {{--Necks--}}
                        @elseif($nhitem->item_id == '140900')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140899')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140898')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @elseif($nhitem->item_id == '140894')
                            <span id="2" data-tooltip-href="http://www.wowdb.com/items/{{$nhitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$nhitem->item_icon}}.jpg">{{$nhitem->item_name}}</span>
                        @endif
                    @endif
                @endforeach
            @elseif($_GET['raid'] == 'Antorus the burning throne')
                @foreach($atbtitems as $atbtitem)
                    <span data-tooltip-href="http://www.wowdb.com/items/{{$atbtitem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$atbtitem->item_icon}}.jpg">{{$atbtitem->item_name}}</span>
                @endforeach
            @elseif($_GET['raid'] == 'Tomb of sargeras')
                @foreach($tositems as $tositem)
                    <span data-tooltip-href="http://www.wowdb.com/items/{{$tositem->item_id}}"><img src="https://render-eu.worldofwarcraft.com/icons/56/{{$tositem->item_icon}}.jpg">{{$tositem->item_name}}</span>
                @endforeach
            @endif
        @else
        @endif
    </div>
</div>

@if(Auth::user()->can('moderate raids'))
    add new raid
    <form method="POST" action="{{route('profile.needlist.update.raid')}}" enctype="multipart/form-data">
        <label for="raid_id">Type raid id:</label>
        <input name="raid_id">
        <label for="raid_name">Type raid name:</label>
        <input name="raid_name">
        <button>submit</button>
        {{ csrf_field() }}
    </form>
    add new raid items
    <form method="POST" action="{{route('profile.needlist.update.item')}}" enctype="multipart/form-data">
        <label for="items_raid_id">Select raid:</label>
        <select name="items_raid_id">
            @foreach($raids as $raid)
                <option value="{{$raid->raid_id}}">
                    {{$raid->raid_name}}
                </option>
            @endforeach
        </select>
        <label for="item_id">Type item id:</label>
        <input name="item_id">
        <button>submit</button>
        {{ csrf_field() }}
    </form>
@else
@endif

</html>