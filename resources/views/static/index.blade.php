
static name: {{$wowstatic->static_name}}
<?php $staticMembers = explode(',',$wowstatic->static_users) ?>

static members:
@foreach($staticMembers as $staticMember)
    {{$staticMember}}
@endforeach

static rl: {{$wowstatic->static_rl}}(