
$(document).ready(function () {

    
    $('.logintext span').click(function(){
          $('.login-form').toggleClass("selected-form");
          $('.logintext span').toggleClass('selected');
    })
    

    $('.add-item-form [name="name"]').on('keyup',function(){
        $('.additem-card .card-title').text($(this).val());
    })
    $('.add-item-form [name="desc"]').on('keyup',function(){
        $('.additem-card .card-text').text($(this).val());
    })
    $('.add-item-form [name="price"]').on('keyup',function(){
        $('.additem-card .price').text("$" + $(this).val());
    })
   

});

