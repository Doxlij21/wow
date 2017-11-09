<!doctype html>
<html style="min-width: 1410px; background-color: #69797e;">
<head>
    <meta name="viewport" content="initial-scale=1.0001, minimum-scale=0.7, user-scalable=yes"/>
    <script src="/js/jquery-3.2.1.min.js"></script>
    <script src="/js/admin/showRP.js"></script>
    <script src="/js/typeahead.js"></script>
    <script src="/js/admin/finduser.js"></script>
    @extends('css.maincss')
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
</head>
<body style="display: none;">
<div class="full-wrap">
    <div id="headerMover">
        <header>
            @include('layouts.lang.lang')
        </header>
        <div id="content" class="indexNews">
            <div class="pageWidth">
                <div class="pageContent">
                    @role('lead admin')
                        <div id="admin">
                            <div class="addRole">
                                <form class="form" action="{{ route ('admin.post.role') }}" enctype="multipart/form-data">
                                    <label for="role">add role</label>
                                    <input type="text" name="role" id="role">
                                    <button type="submit" style="width: 71px;height: 32px;" class="primary button">
                                        <span class="login-text">
                                            submit
                                        </span>
                                    </button>
                                    {!! csrf_field() !!}
                                </form>
                            </div>
                            <div class="allRoles">
                                <div class="showRoles" onclick="showRoles()">
                                    Show all available roles
                                </div>
                                <div style="display: none" class="availableRoles">
                                    <ul>
                                        @foreach($roles as $role)
                                            <li>
                                                @if($role->name == 'lead admin')
                                                    <span style="color: #800020">{{$role->name}}</span>
                                                @elseif($role->name == 'admin')
                                                    <span style="color: red">{{$role->name}}</span>
                                                @elseif($role->name == 'moderator')
                                                    <span style="color: green">{{$role->name}}</span>
                                                @elseif($role->name == 'project team')
                                                    <span style="color: purple">{{$role->name}}</span>
                                                @elseif($role->name == 'raid leader')
                                                    <span style="color: gold">{{$role->name}}</span>
                                                @elseif($role->name == 'member')
                                                    <span>{{$role->name}}</span>
                                                @elseif($role->name == 'banned')
                                                    <strike>{{$role->name}}</strike>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div style="display: none" class="hideRoles" onclick="hideRoles()">
                                    Hide roles
                                </div>
                            </div>
                            <div class="addPermission">
                                <form class="form-vertical" role="form" action="{{ route ('admin.post.permission') }}" method="POST" enctype="multipart/form-data">
                                    <label for="permission">add permission</label>
                                    <input type="text" name="permission">
                                    <button type="submit" style="width: 71px;height: 32px;" class="primary button">
                                        <span class="login-text">
                                            submit
                                        </span>
                                    </button>
                                    {!! csrf_field() !!}
                                </form>
                            </div>
                            <div class="allPermissions">
                                <div class="showPermissions" onclick="showPermissions()">
                                    Show all available permissions
                                </div>
                                <div style="display: none" class="availablePermissions">
                                    <ul>
                                        @foreach($permissions as $permission)
                                             <li>
                                                {{$permission->name}}
                                             </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div style="display: none" class="hidePermissions" onclick="hidePermissions()">
                                    Hide permissions
                                </div>
                            </div>
                            @endrole
                            @role(['lead admin','admin'])
                            <div>
                                <dl class="ctrlUnit">
                                    <dt><label for="search_user"> Search user for assign role for him </label></dt>
                                    <dd>
                                        <input id="search_user">
                                    </dd>
                                </dl>
                                <dl>
                                    <dt id="selectedUser">
                                        <?php
                                        if (count(request()->name) > 0)
                                        {
                                            if (count(\App\User::find($_GET['name'])->roles) > 0 && count(\App\User::find($_GET['name'])->permissions) > 0)
                                                {
                                                    echo 'selected user have this roles:' . ' ';
                                                    foreach (\App\User::find($_GET['name'])->roles as $ro)
                                                        {
                                                            echo $ro->name . ',' . ' ';
                                                        }
                                                     echo 'and this permissions: ' . ' ';
                                                    foreach (\App\User::find($_GET['name'])->permissions as $per)
                                                        {
                                                            echo $per->name . ',' . ' ';
                                                        }
                                                }
                                            elseif(count(\App\User::find($_GET['name'])->roles) > 0 && count(\App\User::find($_GET['name'])->permissions) == 0)
                                                {
                                                    echo 'selected user have this roles:' . ' ';
                                                    foreach (\App\User::find($_GET['name'])->roles as $ro)
                                                        {
                                                            echo $ro->name . ',' . ' ';
                                                        }
                                                    echo ' ' . 'and zero permissions';
                                                }
                                            elseif(count(\App\User::find($_GET['name'])->permissions) > 0 && count(\App\User::find($_GET['name'])->roles) == 0)
                                                {
                                                    echo 'selected user have zero roles' . ' ' . 'and this permissions: ' . ' ';
                                                    foreach(\App\User::find($_GET['name'])->permissions as $per)
                                                        {
                                                            echo $per->name . ',' . ' ';
                                                        }
                                                }
                                            elseif(count(\App\User::find($_GET['name'])->permissions) == 0 && count(\App\User::find($_GET['name'])->roles) == 0)
                                                {
                                                    echo 'this user have zero roles and zero permissions';
                                                }
                                        } else{
                                            echo 'Choose user to see his roles and permissions';
                                        }
                                        ?>
                                    </dt>
                                </dl>
                                <dl class="ctrlUnit">
                                    <dt><label for="assignRole"> Select what you want to do with this user </label></dt>
                                    <dd>
                                        <input class="optarole" type="checkbox"> Assign role <br>
                                        <input class="optrrole" type="checkbox"> Revoke role <br>
                                        @role('lead admin')
                                            <input class="optapermission" type="checkbox"> Assign permission <br>
                                            <input class="optrpermission" type="checkbox"> Revoke permission <br>
                                        @endrole

                                    </dd>
                                </dl>
                                <form action="{{route('admin.assign.role')}}">
                                    <div id="roleoptassign" class="roleoptassign">
                                        <label for="role"> Select role to assign: </label>
                                        <select id="role" name="role">
                                            <option id="role" name="role" value='' ></option>
                                            @foreach($roles as $rol)
                                                @role('lead admin')
                                                    @if (count(request()->name) > 0)
                                                        @if (count(\App\User::find($_GET['name'])->roles) > 0)
                                                            @foreach(\App\User::find($_GET['name'])->roles as $uplroles)
                                                                @if($uplroles->name == 'lead admin')
                                                                @else
                                                                    <option id="role" name="role" value='{{$rol->name}}' >{{$rol->name}}</option>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                        @endif
                                                    @else
                                                        @if($rol->name == 'lead admin')
                                                        @else
                                                            <option id="role" name="role" value='{{$rol->name}}' >{{$rol->name}}</option>
                                                        @endif
                                                    @endif
                                                @endrole
                                                @role('admin')
                                                    @if (count(request()->name) > 0)
                                                        @if (count(\App\User::find($_GET['name'])->roles) > 0)
                                                            @foreach(\App\User::find($_GET['name'])->roles as $uproles)
                                                                @if($uproles->name == 'lead admin')
                                                                @elseif($uproles->name == 'admin')
                                                                @else
                                                                    <option id="role" name="role" value='{{$uproles->name}}' >{{$uproles->name}}</option>
                                                                @endif
                                                            @endforeach
                                                        @else
                                                        @endif
                                                    @else
                                                        @if($rol->name == 'lead admin')
                                                        @elseif($rol->name == 'admin')
                                                        @else
                                                            <option id="role" name="role" value='{{$rol->name}}' >{{$rol->name}}</option>
                                                        @endif
                                                    @endif
                                                @endrole
                                            @endforeach
                                        </select>
                                    </div>


                                    <div id="roleoptrevoke">
                                        <label for="rolerevoke"> Select role to revoke: </label>
                                        <select id="rolerevoke" name="rolerevoke">
                                            @if (count(request()->name) > 0)
                                                @if (count(\App\User::find($_GET['name'])->roles) > 0)
                                                    <option id='rolerevoke' name='rolerevoke' value=''></option>
                                                    @foreach (\App\User::find($_GET['name'])->roles as $role)
                                                        @role('lead admin')
                                                            @if($role->name == 'lead admin')
                                                            @else
                                                                <option id='rolerevoke' name='rolerevoke' value='{{$role->name}}'> {{$role->name}} </option>
                                                            @endif
                                                        @endrole
                                                        @role('admin')
                                                            @if(\App\User::find($_GET['name'])->roles == 'lea')
                                                            @else
                                                                @if ($role->name == 'lead admin')
                                                                @elseif($role->name == 'admin')
                                                                @else
                                                                    <option id='rolerevoke' name='rolerevoke' value='{{$role->name}}'> {{$role->name}} </option>
                                                                @endif
                                                            @endif
                                                        @endrole
                                                    @endforeach
                                                @elseif(count(\App\User::find($_GET['name'])->roles) == 0)
                                                    <option id="rolerevoke" name="rolerevoke" value=""> this user have nothing to revoke </option>
                                                @endif
                                            @else
                                                <option id="rolerevoke" name="rolerevoke" value=""> none user is selected </option>
                                            @endif
                                        </select>
                                    </div>
                                    @role('lead admin')
                                        <div class="permissionoptassign" style="display: none">
                                            <label for="permission"> Select permission to assign: </label>
                                            <select id="permission" name="permission">
                                                <option id="permission" name="permission" value=''></option>
                                                @foreach($permissions as $perm)
                                                        <option id="permission" name="permission" value='{{$perm->name}}' >{{$perm->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endrole

                                    @role('lead admin')
                                        <div id="permissionoptrevoke">
                                            <label for="permissionrevoke"> Select permission to revoke: </label>
                                            <select id="permissionrevoke" name="permissionrevoke">
                                                <?php
                                                if (count(request()->name) > 0)
                                                {
                                                    if (count(\App\User::find($_GET['name'])->permissions) > 0)
                                                    {
                                                        echo "<option id='permissionrevoke' name='permissionrevoke' value=''></option>";
                                                        foreach (\App\User::find($_GET['name'])->permissions as $perm)
                                                        {
                                                            echo "<option id='permissionrevoke' name='permissionrevoke' value='$perm->name'> $perm->name </option>";
                                                        }
                                                    }
                                                    elseif(count(\App\User::find($_GET['name'])->permissions) == 0)
                                                    {
                                                        echo '<option id="permissionrevoke" name="permissionrevoke" value=""> this user have nothing to revoke </option>';
                                                    }
                                                }else{
                                                    echo '<option id="permissionrevoke" name="permissionrevoke" value=""> none user is selected </option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    @endrole
                                    <dl style="display: none" class="ctrlUnitId">
                                        <dd>
                                            <input name="search_user_id" id="search_user_id">
                                        </dd>
                                    </dl>

                                    <button type="submit" style="width: 71px;height: 32px;" class="primary button">
                                        <span style="line-height: 0px !important;" class="js-login-text">
                                            submit
                                        </span>
                                    </button>

                                    <input type="hidden" name="_token" value="{{Session::token()}}">
                                </form>
                            </div>
                            @endrole
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
<script src="/js/admin/adminOptions.js"></script>
<script src="/js/lang/lang.js"></script>
<script src="/js/menu/menu.js"></script>
</html>