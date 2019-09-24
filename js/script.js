$('nav .navigation a').click(function(e){
    e.preventDefault();
    e.stopPropagation();
    let cl = $(this).attr('href');
    if(cl!=='all'){
        $('section:not(.'+cl+')').fadeOut();
        $('section.'+cl).fadeIn();
    }else{
        $('section').fadeIn();
    }
    $(this).parent().removeClass('open');
});

$('nav .toggle').click(function(){
    $($(this).attr('rel')).toggleClass('open')
});