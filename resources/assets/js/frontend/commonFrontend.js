/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    var pgurl = window.location.href;
    $(".navbar-right li a").each(function() {
        if ($(this).attr("href") === pgurl || $(this).attr("href") === ''){
            $('.navbar-right li.main_li').removeClass("active-menu");
            $(this).closest('.main_li').addClass("active-menu");
        }
    });
     $('.money').mask('000,000,000,000,000', {reverse: true});
});
