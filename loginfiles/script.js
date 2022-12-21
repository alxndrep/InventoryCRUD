$('#login-button').click(function(){
  $('#login-button').fadeOut("slow",function(){
    $("#container").fadeIn();
    TweenMax.from("#container", .4, { scale: 0, ease:Sine.easeInOut});
    TweenMax.to("#container", .4, { scale: 1, ease:Sine.easeInOut});
  });
});

$(".close-btn").click(function(){
  TweenMax.from("#container", .4, { scale: 1, ease:Sine.easeInOut});
  TweenMax.to("#container", .4, { left:"0px", scale: 0, ease:Sine.easeInOut});
  $("#container, #forgotten-container").fadeOut(800, function(){
    $("#login-button").fadeIn(800);
  });
});


jQuery(document).on('submit', '#formlg', function(event){
  event.preventDefault();

  jQuery.ajax({
    url: 'loginuserdb.php',
    type: 'POST',
    dataType: 'json',
    data: $(this).serialize(),
    beforeSend: function(){
        $('.botonsbt').val('Iniciando...')
    }
  })
  .done(function(respuesta){
    if(!respuesta.error){
        location.href = '../index.php';
    }else{
        $('.errorlg').slideDown('slow');
        setTimeout(function(){
            $('.errorlg').slideUp('slow');
        },4000);
        $('.botonsbt').val('Entrar');
    }
  })
  .fail(function(resp){
    console.log(resp.responseText);
  });
});