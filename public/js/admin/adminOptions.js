var chk1 = $('input.optapermission');
var chk2 = $('input.optarole');
var chk3 = $('input.optrpermission');
var chk4 = $('input.optrrole');
var chk5 = $('.roleoptassign') ;
var chk6 = $('#roleoptrevoke');
var chk7 = $('.permissionoptassign');
var chk8 = $('#permissionoptrevoke');
chk6.hide();
chk8.hide();
chk5.hide();

if (chk2.is(':selected'))
{
    chk5.show();
}
if (chk4.is(':selected'))
{
    chk6.show();
}

if (chk3.is(':selected'))
{
    chk8.show();
}

chk2.on('change', function(){
    chk4.not(this).prop('checked', false);
    chk5.toggle();
    chk6.hide();

});
chk4.on('change', function(){
    chk2.not(this).prop('checked', false);
    chk5.hide();
    chk6.toggle();

});
chk1.on('change', function(){
    chk3.not(this).prop('checked', false);
    chk7.toggle();
    chk8.hide();

});
chk3.on('change', function(){
    chk1.not(this).prop('checked', false);
    chk7.hide();
    chk8.toggle();

});