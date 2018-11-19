var font_size_control = 0;
var high_contrast = 'false';
(function(){	
	$(window).load(function(){
		$('body').addClass('no-transition');
		$('body *').each(function(){
			$(this).css('font-size',parseInt($(this).css('font-size')) + 'px');				
		});
		$('body').removeClass('no-transition');

		var cookie_font_size_control = readCookie('font_size_control');	
		if(cookie_font_size_control){

			font_size_control = parseInt(cookie_font_size_control);
			
			if(font_size_control > 0){
				$('body').addClass('no-transition');
				$('body *').each(function(){					
					//console.log(parseFloat($(this).css('font-size')) + font_size_control + 'px');
					$(this).css('font-size',parseInt($(this).css('font-size')) + font_size_control + 'px');				
				});		
				$('body').removeClass('no-transition');	
			}
		}
		
		$('[data-toggle="accessibility-font-size-control"]').on('click',function(e){				
			if($(this).data('accessibility-control') == 'plus' && font_size_control < 10){

				font_size_control = font_size_control + 1;
				createCookie('font_size_control',font_size_control,7);
				$('body').addClass('no-transition');
				$('body *').each(function(){
					$(this).css('font-size',parseInt($(this).css('font-size')) + 1 + 'px');				
				});
				$('body').removeClass('no-transition');
			}else
				if($(this).data('accessibility-control') == 'minus' && font_size_control > 0){
					font_size_control = font_size_control - 1;
					createCookie('font_size_control',font_size_control,7);
					$('body').addClass('no-transition');
					$('body *').each(function(){
						$(this).css('font-size',parseInt($(this).css('font-size')) - 1 + 'px');
					});
					$('body').removeClass('no-transition');
				}
		});

		var cookie_high_contrast = readCookie('high_contrast');
		if(cookie_high_contrast){
			high_contrast = cookie_high_contrast; 
			if(high_contrast == 'true'){
				$('body').addClass('highcontrast');
			}
		}

		$("[data-toggle='accesibility-contrast-control']").on('click',function(e){
			if($('body').hasClass('highcontrast')){
				high_contrast = 'false';
				createCookie('high_contrast',high_contrast,7);
			}else{
				high_contrast = 'true';
				createCookie('high_contrast',high_contrast,7);
			}
			$('body').toggleClass('highcontrast');
		});

	});
})();

function createCookie(name,value,days) { if (days) { var date = new Date(); date.setTime(date.getTime()+(days*24*60*60*1000)); var expires = "; expires="+date.toGMTString(); } else var expires = ""; document.cookie = name+"="+value+expires+"; path=/"; } 
function readCookie(name) { var nameEQ = name + "="; var ca = document.cookie.split(";"); for(var i=0;i < ca.length;i++) { var c = ca[i]; while (c.charAt(0)==" ") c = c.substring(1,c.length); if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length); } return null; }

$(document).ready(function(){
	$('.popup-flash-container').find('.button-close').on('click',function(){
        $(this).closest('.popup-flash-container').remove();
    });
    $('.slide-content').find('.img-responsive').css('margin','0 auto');
    $('.slide-content').find('.img-responsive').css('width','100%');
    $('.slide-content').find('.img-responsive').css('height','auto');
    $('.slide-content').find('p').css('line-height','25px');
    $('.slide-content').find('iframe').css('width','100%');
    $('.slide-content').find('iframe').css('heigth','auto');
});

function changeBiometria(token){
            
    window.location = '/virtual_rooms/biometria_facial/'+token;
    //$.get('/virtual_rooms/biometria_facial/'+token ,function(data){
    //    alert(data);
    //});
}