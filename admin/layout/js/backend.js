
$(document).ready(function () {

    // $('h1').css("color",'red');
  
    $('.toogle-info').click(function(){
        $(this).toggleClass('selected').parent().next('.card-body').slideToggle();

        if($(this).hasClass('selected')){
            $(this).html('<i class="fa fa-minus "></i>');
        }
        else{
            $(this).html('<i class="fa fa-plus "></i>');
        }

    })

});

