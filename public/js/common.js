var Main = {
    init: function () {

        //переключение чекбокса
        $('#remember_label').on('click', function () {
          if($('#remember_checkbox').prop("checked")===true){
            $('#remember_label .checkbox_span').css({"background": "url('/public/libs/img/ch.png') center no-repeat"});
          }else{
            $('#remember_label .checkbox_span').css({"background": "none"});
          }
        });



        
var iframe = $('iframe').contents().find('body'); 

        console.log(6);
        console.log(iframe);
    },


};

$(function () {
    Main.init();
});
