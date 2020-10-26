$(document).ready(function(){

    
});

$(document).on('submit','form',function(e){

    if($(this).hasClass('ajax-form')){
    e.preventDefault()
    let url = $(this).attr('action');
    let target = ('#'+$(this).attr('id') == '#undefined') ? 'body' : '#'+$(this).attr('id');
    $.easyAjax({
        url: url,
        container: target,
		disableButton: true,
        type: "POST",
        redirect: true,
        file: false,
        data: $(this).serialize(),
        messagePosition:'toastr',
    }, function(res){
       console.log(res)
    });
  }
});
