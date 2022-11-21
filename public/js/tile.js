$(function(){
    var minWidth = 450;
    if (minWidth <= $(this).width()) {
    $('.box_tile').tile();
      $(window).load(function() {
    $('.box_tile').tile();
      });
                }
    $(window).resize(function(){
        if (minWidth <= $(this).width()) {
    $('.box_tile').tile();
        }
        else {
            $('.box_tile').removeAttr('style');
        }
    });
});
