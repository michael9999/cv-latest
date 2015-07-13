(function($) {

	$(function() {
		try {
			if (typeof _wpcf7 == 'undefined' || _wpcf7 === null)
				_wpcf7 = {};

			_wpcf7 = $.extend({ cached: 0 }, _wpcf7);

			_wpcf7.supportHtml5Placeholder
				= 'placeholder' in document.createElement('input');

			$('div.wpcf7 > form').ajaxForm({
				beforeSubmit: function(formData, jqForm, options) {
					jqForm.wpcf7ClearResponseOutput();
					jqForm.find('img.ajax-loader').css({ visibility: 'visible' });
					//jQuery("<p>Merci de patienter</p>").insertAfter( "#test-paypal" );
					jQuery('#wait-plz').toggle("slow");
					return true;
				},
				beforeSerialize: function(jqForm, options) {
					jqForm.find('[placeholder].placeheld').each(function(i, n) {
						$(n).val('');
					});
					return true;
				},
				data: { '_wpcf7_is_ajax_call': 1 },
				dataType: 'json',
				success: function(data) {
					if (! $.isPlainObject(data) || $.isEmptyObject(data))
						return;

					var ro = $(data.into).find('div.wpcf7-response-output');
					$(data.into).wpcf7ClearResponseOutput();

					$(data.into).find('.wpcf7-form-control').removeClass('wpcf7-not-valid');
					$(data.into).find('form.wpcf7-form').removeClass('invalid spam sent failed');

					if (data.captcha)
						$(data.into).wpcf7RefillCaptcha(data.captcha);

					if (data.quiz)
						$(data.into).wpcf7RefillQuiz(data.quiz);

					if (data.invalids) {
						$.each(data.invalids, function(i, n) {
							$(data.into).find(n.into).wpcf7NotValidTip(n.message);
							$(data.into).find(n.into).find('.wpcf7-form-control').addClass('wpcf7-not-valid');
						});

						ro.addClass('wpcf7-validation-errors');
						$(data.into).find('form.wpcf7-form').addClass('invalid');

						$(data.into).trigger('invalid.wpcf7');

					} else if (1 == data.spam) {
						ro.addClass('wpcf7-spam-blocked');
						$(data.into).find('form.wpcf7-form').addClass('spam');

						$(data.into).trigger('spam.wpcf7');

					} else if (1 == data.mailSent) {
						ro.addClass('wpcf7-mail-sent-ok');
						$(data.into).find('form.wpcf7-form').addClass('sent');

						if (data.onSentOk)
							$.each(data.onSentOk, function(i, n) { eval(n) });

						$(data.into).trigger('mailsent.wpcf7');

					} else {
						ro.addClass('wpcf7-mail-sent-ng');
						$(data.into).find('form.wpcf7-form').addClass('failed');

						$(data.into).trigger('mailfailed.wpcf7');
					}

					if (data.onSubmit)
						$.each(data.onSubmit, function(i, n) { eval(n) });

					$(data.into).trigger('submit.wpcf7');

					if (1 == data.mailSent)
						$(data.into).find('form').resetForm().clearForm();
					
					// my test 
					
						//alert("data has been sent");
						

					$(data.into).find('[placeholder].placeheld').each(function(i, n) {
						$(n).val($(n).attr('placeholder'));
					});

					$(data.into).wpcf7FillResponseOutput(data.message);
				}
			});

//******************* MY CHANGES FOR POST VALIDATION ACTIONS ********************/
			
			function myTest2(){
			    
			    //alert("this is my test2");
			    test = jQuery('#test-service').val();
			    
			    
			    if(test=='Verification de CV (gratuit)')
			    
			    {   
			        jQuery('#free-send-to-msg').toggle("slow");
			        jQuery('#wpcf7-f357-p363-o1').hide();
			        // scroll to confirmation message 
    			          jQuery('html, body').animate({
                                    scrollTop: jQuery("#primary").offset().top
                                }, 100);
			        
			        location = 'http://www.test-sw2.com/staging-cv-en-anglais/correction-de-cv-confirmation-page.html';}
    			    
    			    else if(test=='Correction de CV (35 euros)') 
    			        { cost = 35; product=test; 
    			          jQuery('#paypal-send-to-msg').toggle("slow");
    			          //alert("about to hide form");
    			          jQuery('#wpcf7-f327-p325-o1').hide();
    			          
    			                jQuery('html, body').animate({
                                    scrollTop: jQuery("#primary").offset().top
                                }, 100);
    			          
    			          
    			          location = 'https://www.paypal.com/cgi-bin/webscr?business=idegreeuk@gmail.com&cmd=_xclick&currency_code=EUR&quantity=1&item_name=' 
			    + product + '&item_number=100&notify_url=&return=http://www.test-sw2.com&cancel_return=http://www.test-sw2.com&amount=' + cost;
    			        }
    			        
    			    else if(test=='Traduction de CV (49 euros)')
    			        { cost = 49; product=test;
    			          jQuery('#paypal-send-to-msg').toggle("slow");
    			          jQuery('#wpcf7-f358-p365-o1').hide();
    			          
    			          // scroll to confirmation message 
    			          jQuery('html, body').animate({
                                    scrollTop: jQuery("#primary").offset().top
                                }, 100);
    			          
    			          
    			          location = 'https://www.paypal.com/cgi-bin/webscr?business=idegreeuk@gmail.com&cmd=_xclick&currency_code=EUR&quantity=1&item_name=' 
			    + product + '&item_number=100&notify_url=&return=http://www.test-sw2.com&cancel_return=http://www.test-sw2.com&amount=' + cost;
    			        
    			        }
    			        
    			    else if(test=='Entretien en anglais (65 euros)')
    			        { cost = 65; product=test;
    			        //alert("about to hide form");
    			          jQuery('#wpcf7-f359-p361-o1').hide();  
    			          jQuery('#paypal-send-to-msg').toggle("slow");
    			          
    			          
    			          // scroll to confirmation message 
    			          jQuery('html, body').animate({
                                    scrollTop: jQuery("#primary").offset().top
                                }, 100);
    			          
    			          location = 'https://www.paypal.com/cgi-bin/webscr?business=idegreeuk@gmail.com&cmd=_xclick&currency_code=EUR&quantity=1&item_name=' 
			    + product + '&item_number=100&notify_url=&return=http://www.test-sw2.com&cancel_return=http://www.test-sw2.com&amount=' + cost;
    			        
    			        }
    			    
			    else {} 
			    //jQuery('#wpcf7-f327-p325-o1').hide();
			    
	// if free service (verification de CV) don't show paypal page		    
			    
			   
			 
			    
			}
			
//******************* END OF MY CHANGES ********************/			
			

			$('div.wpcf7 > form').each(function(i, n) {
				if (_wpcf7.cached)
					$(n).wpcf7OnloadRefill();

				$(n).wpcf7ToggleSubmit();

				$(n).find('.wpcf7-submit').wpcf7AjaxLoader();

				$(n).find('.wpcf7-acceptance').click(function() {
					$(n).wpcf7ToggleSubmit();
				});

				$(n).find('.wpcf7-exclusive-checkbox').each(function(i, n) {
					$(n).find('input:checkbox').click(function() {
						$(n).find('input:checkbox').not(this).removeAttr('checked');
					});
				});

				$(n).find('[placeholder]').each(function(i, n) {
					var input = $(n);

					if (_wpcf7.supportHtml5Placeholder)
						return;

					input.val(input.attr('placeholder'));
					input.addClass('placeheld');

					input.focus(function() {
						if ($(this).hasClass('placeheld'))
							$(this).val('').removeClass('placeheld');
					});

					input.blur(function() {
						if ('' == $(this).val()) {
							$(this).val($(this).attr('placeholder'));
							$(this).addClass('placeheld');
						}
					});
				});
			});

		} catch (e) {
		}
	});

	$.fn.wpcf7AjaxLoader = function() {
		return this.each(function() {
			var loader = $('<img class="ajax-loader" />')
				.attr({ src: _wpcf7.loaderUrl, alt: _wpcf7.sending })
				.css('visibility', 'hidden');

			$(this).after(loader);
		});
	};

	$.fn.wpcf7ToggleSubmit = function() {
		return this.each(function() {
			var form = $(this);
			if (this.tagName.toLowerCase() != 'form')
				form = $(this).find('form').first();

			if (form.hasClass('wpcf7-acceptance-as-validation'))
				return;

			var submit = form.find('input:submit');
			if (! submit.length) return;

			var acceptances = form.find('input:checkbox.wpcf7-acceptance');
			if (! acceptances.length) return;

			submit.removeAttr('disabled');
			acceptances.each(function(i, n) {
				n = $(n);
				if (n.hasClass('wpcf7-invert') && n.is(':checked')
				|| ! n.hasClass('wpcf7-invert') && ! n.is(':checked'))
					submit.attr('disabled', 'disabled');
			});
		});
	};

	$.fn.wpcf7NotValidTip = function(message) {
		return this.each(function() {
			var into = $(this);
			into.append('<span class="wpcf7-not-valid-tip">' + message + '</span>');
			$('span.wpcf7-not-valid-tip').mouseover(function() {
				$(this).fadeOut('fast');
			});
			into.find(':input').mouseover(function() {
				into.find('.wpcf7-not-valid-tip').not(':hidden').fadeOut('fast');
			});
			into.find(':input').focus(function() {
				into.find('.wpcf7-not-valid-tip').not(':hidden').fadeOut('fast');
			});
		});
	};

	$.fn.wpcf7OnloadRefill = function() {
		return this.each(function() {
			var url = $(this).attr('action');
			if (0 < url.indexOf('#'))
				url = url.substr(0, url.indexOf('#'));

			var id = $(this).find('input[name="_wpcf7"]').val();
			var unitTag = $(this).find('input[name="_wpcf7_unit_tag"]').val();

			$.getJSON(url,
				{ _wpcf7_is_ajax_call: 1, _wpcf7: id, _wpcf7_request_ver: $.now() },
				function(data) {
					if (data && data.captcha)
						$('#' + unitTag).wpcf7RefillCaptcha(data.captcha);

					if (data && data.quiz)
						$('#' + unitTag).wpcf7RefillQuiz(data.quiz);
				}
			);
		});
	};

	$.fn.wpcf7RefillCaptcha = function(captcha) {
		return this.each(function() {
			var form = $(this);

			$.each(captcha, function(i, n) {
				form.find(':input[name="' + i + '"]').clearFields();
				form.find('img.wpcf7-captcha-' + i).attr('src', n);
				var match = /([0-9]+)\.(png|gif|jpeg)$/.exec(n);
				form.find('input:hidden[name="_wpcf7_captcha_challenge_' + i + '"]').attr('value', match[1]);
			});
		});
	};

	$.fn.wpcf7RefillQuiz = function(quiz) {
		return this.each(function() {
			var form = $(this);

			$.each(quiz, function(i, n) {
				form.find(':input[name="' + i + '"]').clearFields();
				form.find(':input[name="' + i + '"]').siblings('span.wpcf7-quiz-label').text(n[0]);
				form.find('input:hidden[name="_wpcf7_quiz_answer_' + i + '"]').attr('value', n[1]);
			});
		});
	};

	$.fn.wpcf7ClearResponseOutput = function() {
		return this.each(function() {
			$(this).find('div.wpcf7-response-output').hide().empty().removeClass('wpcf7-mail-sent-ok wpcf7-mail-sent-ng wpcf7-validation-errors wpcf7-spam-blocked');
			$(this).find('span.wpcf7-not-valid-tip').remove();
			$(this).find('img.ajax-loader').css({ visibility: 'hidden' });
		});
	};

	$.fn.wpcf7FillResponseOutput = function(message) {
		return this.each(function() {
			$(this).find('div.wpcf7-response-output').append(message).slideDown('fast');
		});
	};

})(jQuery);