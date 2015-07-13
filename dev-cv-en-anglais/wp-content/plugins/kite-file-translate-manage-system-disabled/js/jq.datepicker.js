(function($) {
	$.extend($.ui, {
		datepicker : {
			version : "1.7.1"
		}
	});
	var PROP_NAME = "datepicker";
	function Datepicker() {
		this.debug = false;
		this._curInst = null;
		this._keyEvent = false;
		this._disabledInputs = [];
		this._datepickerShowing = false;
		this._inDialog = false;
		this._mainDivId = "ui-datepicker-div";
		this._inlineClass = "ui-datepicker-inline";
		this._appendClass = "ui-datepicker-append";
		this._triggerClass = "ui-datepicker-trigger";
		this._dialogClass = "ui-datepicker-dialog";
		this._disableClass = "ui-datepicker-disabled";
		this._unselectableClass = "ui-datepicker-unselectable";
		this._currentClass = "ui-datepicker-current-day";
		this._dayOverClass = "ui-datepicker-days-cell-over";
		this.regional = [];
		this.regional[""] = {
			closeText : "Done",
			prevText : "Prev",
			nextText : "Next",
			currentText : "Today",
			monthNames : [ "January", "February", "March", "April", "May",
					"June", "July", "August", "September", "October",
					"November", "December" ],
			monthNamesShort : [ "Jan", "Feb", "Mar", "Apr", "May", "Jun",
					"Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ],
			dayNames : [ "Sunday", "Monday", "Tuesday", "Wednesday",
					"Thursday", "Friday", "Saturday" ],
			dayNamesShort : [ "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat" ],
			dayNamesMin : [ "Su", "Mo", "Tu", "We", "Th", "Fr", "Sa" ],
			dateFormat : "mm/dd/yy",
			firstDay : 0,
			isRTL : false
		};
		this._defaults = {
			showOn : "focus",
			showAnim : "show",
			showOptions : {},
			defaultDate : null,
			appendText : "",
			buttonText : "...",
			buttonImage : "",
			buttonImageOnly : false,
			hideIfNoPrevNext : false,
			navigationAsDateFormat : false,
			gotoCurrent : false,
			changeMonth : false,
			changeYear : false,
			showMonthAfterYear : false,
			yearRange : "-10:+10",
			showOtherMonths : false,
			calculateWeek : this.iso8601Week,
			shortYearCutoff : "+10",
			minDate : null,
			maxDate : null,
			duration : "normal",
			beforeShowDay : null,
			beforeShow : null,
			onSelect : null,
			onChangeMonthYear : null,
			onClose : null,
			numberOfMonths : 1,
			showCurrentAtPos : 0,
			stepMonths : 1,
			stepBigMonths : 12,
			altField : "",
			altFormat : "",
			constrainInput : true,
			showButtonPanel : false
		};
		$.extend(this._defaults, this.regional[""]);
		this.dpDiv = $('<div id="' + this._mainDivId + '" class="ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all ui-helper-hidden-accessible"></div>')
	}
	$
			.extend(
					Datepicker.prototype,
					{
						markerClassName : "hasDatepicker",
						log : function() {
							if (this.debug) {
								console.log.apply("", arguments)
							}
						},
						setDefaults : function(settings) {
							extendRemove(this._defaults, settings || {});
							return this
						},
						_attachDatepicker : function(target, settings) {
							var inlineSettings = null;
							for ( var attrName in this._defaults) {
								var attrValue = target.getAttribute("date:"
										+ attrName);
								if (attrValue) {
									inlineSettings = inlineSettings || {};
									try {
										inlineSettings[attrName] = eval(attrValue)
									} catch (err) {
										inlineSettings[attrName] = attrValue
									}
								}
							}
							var nodeName = target.nodeName.toLowerCase();
							var inline = (nodeName == "div" || nodeName == "span");
							if (!target.id) {
								target.id = "dp" + (++this.uuid)
							}
							var inst = this._newInst($(target), inline);
							inst.settings = $.extend( {}, settings || {},
									inlineSettings || {});
							if (nodeName == "input") {
								this._connectDatepicker(target, inst)
							} else {
								if (inline) {
									this._inlineDatepicker(target, inst)
								}
							}
						},
						_newInst : function(target, inline) {
							var id = target[0].id.replace(/([:\[\]\.])/g,
									"\\\\$1");
							return {
								id : id,
								input : target,
								selectedDay : 0,
								selectedMonth : 0,
								selectedYear : 0,
								drawMonth : 0,
								drawYear : 0,
								inline : inline,
								dpDiv : (!inline ? this.dpDiv
										: $('<div class="' + this._inlineClass + ' ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all"></div>'))
							}
						},
						_connectDatepicker : function(target, inst) {
							var input = $(target);
							inst.trigger = $( []);
							if (input.hasClass(this.markerClassName)) {
								return
							}
							var appendText = this._get(inst, "appendText");
							var isRTL = this._get(inst, "isRTL");
							if (appendText) {
								input[isRTL ? "before" : "after"]
										('<span class="' + this._appendClass
												+ '">' + appendText + "</span>")
							}
							var showOn = this._get(inst, "showOn");
							if (showOn == "focus" || showOn == "both") {
								input.focus(this._showDatepicker)
							}
							if (showOn == "button" || showOn == "both") {
								var buttonText = this._get(inst, "buttonText");
								var buttonImage = this
										._get(inst, "buttonImage");
								inst.trigger = $(this._get(inst,
										"buttonImageOnly") ? $("<img/>")
										.addClass(this._triggerClass).attr( {
											src : buttonImage,
											alt : buttonText,
											title : buttonText
										}) : $(
										'<button type="button"></button>')
										.addClass(this._triggerClass).html(
												buttonImage == "" ? buttonText
														: $("<img/>").attr( {
															src : buttonImage,
															alt : buttonText,
															title : buttonText
														})));
								input[isRTL ? "before" : "after"](inst.trigger);
								inst.trigger
										.click(function() {
											if ($.datepicker._datepickerShowing
													&& $.datepicker._lastInput == target) {
												$.datepicker._hideDatepicker()
											} else {
												$.datepicker
														._showDatepicker(target)
											}
											return false
										})
							}
							input.addClass(this.markerClassName).keydown(
									this._doKeyDown).keypress(this._doKeyPress)
									.bind("setData.datepicker",
											function(event, key, value) {
												inst.settings[key] = value
											}).bind("getData.datepicker",
											function(event, key) {
												return this._get(inst, key)
											});
							$.data(target, PROP_NAME, inst)
						},
						_inlineDatepicker : function(target, inst) {
							var divSpan = $(target);
							if (divSpan.hasClass(this.markerClassName)) {
								return
							}
							divSpan.addClass(this.markerClassName).append(
									inst.dpDiv).bind("setData.datepicker",
									function(event, key, value) {
										inst.settings[key] = value
									}).bind("getData.datepicker",
									function(event, key) {
										return this._get(inst, key)
									});
							$.data(target, PROP_NAME, inst);
							this._setDate(inst, this._getDefaultDate(inst));
							this._updateDatepicker(inst);
							this._updateAlternate(inst)
						},
						_dialogDatepicker : function(input, dateText, onSelect,
								settings, pos) {
							var inst = this._dialogInst;
							if (!inst) {
								var id = "dp" + (++this.uuid);
								this._dialogInput = $('<input type="text" id="' + id + '" size="1" style="position: absolute; top: -100px;"/>');
								this._dialogInput.keydown(this._doKeyDown);
								$("body").append(this._dialogInput);
								inst = this._dialogInst = this._newInst(
										this._dialogInput, false);
								inst.settings = {};
								$.data(this._dialogInput[0], PROP_NAME, inst)
							}
							extendRemove(inst.settings, settings || {});
							this._dialogInput.val(dateText);
							this._pos = (pos ? (pos.length ? pos : [ pos.pageX,
									pos.pageY ]) : null);
							if (!this._pos) {
								var browserWidth = window.innerWidth
										|| document.documentElement.clientWidth
										|| document.body.clientWidth;
								var browserHeight = window.innerHeight
										|| document.documentElement.clientHeight
										|| document.body.clientHeight;
								var scrollX = document.documentElement.scrollLeft
										|| document.body.scrollLeft;
								var scrollY = document.documentElement.scrollTop
										|| document.body.scrollTop;
								this._pos = [
										(browserWidth / 2) - 100 + scrollX,
										(browserHeight / 2) - 150 + scrollY ]
							}
							this._dialogInput.css("left", this._pos[0] + "px")
									.css("top", this._pos[1] + "px");
							inst.settings.onSelect = onSelect;
							this._inDialog = true;
							this.dpDiv.addClass(this._dialogClass);
							this._showDatepicker(this._dialogInput[0]);
							if ($.blockUI) {
								$.blockUI(this.dpDiv)
							}
							$.data(this._dialogInput[0], PROP_NAME, inst);
							return this
						},
						_destroyDatepicker : function(target) {
							var $target = $(target);
							var inst = $.data(target, PROP_NAME);
							if (!$target.hasClass(this.markerClassName)) {
								return
							}
							var nodeName = target.nodeName.toLowerCase();
							$.removeData(target, PROP_NAME);
							if (nodeName == "input") {
								inst.trigger.remove();
								$target.siblings("." + this._appendClass)
										.remove().end().removeClass(
												this.markerClassName).unbind(
												"focus", this._showDatepicker)
										.unbind("keydown", this._doKeyDown)
										.unbind("keypress", this._doKeyPress)
							} else {
								if (nodeName == "div" || nodeName == "span") {
									$target.removeClass(this.markerClassName)
											.empty()
								}
							}
						},
						_enableDatepicker : function(target) {
							var $target = $(target);
							var inst = $.data(target, PROP_NAME);
							if (!$target.hasClass(this.markerClassName)) {
								return
							}
							var nodeName = target.nodeName.toLowerCase();
							if (nodeName == "input") {
								target.disabled = false;
								inst.trigger.filter("button").each(function() {
									this.disabled = false
								}).end().filter("img").css( {
									opacity : "1.0",
									cursor : ""
								})
							} else {
								if (nodeName == "div" || nodeName == "span") {
									var inline = $target.children("."
											+ this._inlineClass);
									inline.children().removeClass(
											"ui-state-disabled")
								}
							}
							this._disabledInputs = $.map(this._disabledInputs,
									function(value) {
										return (value == target ? null : value)
									})
						},
						_disableDatepicker : function(target) {
							var $target = $(target);
							var inst = $.data(target, PROP_NAME);
							if (!$target.hasClass(this.markerClassName)) {
								return
							}
							var nodeName = target.nodeName.toLowerCase();
							if (nodeName == "input") {
								target.disabled = true;
								inst.trigger.filter("button").each(function() {
									this.disabled = true
								}).end().filter("img").css( {
									opacity : "0.5",
									cursor : "default"
								})
							} else {
								if (nodeName == "div" || nodeName == "span") {
									var inline = $target.children("."
											+ this._inlineClass);
									inline.children().addClass(
											"ui-state-disabled")
								}
							}
							this._disabledInputs = $.map(this._disabledInputs,
									function(value) {
										return (value == target ? null : value)
									});
							this._disabledInputs[this._disabledInputs.length] = target
						},
						_isDisabledDatepicker : function(target) {
							if (!target) {
								return false
							}
							for ( var i = 0; i < this._disabledInputs.length; i++) {
								if (this._disabledInputs[i] == target) {
									return true
								}
							}
							return false
						},
						_getInst : function(target) {
							try {
								return $.data(target, PROP_NAME)
							} catch (err) {
								throw "Missing instance data for this datepicker"
							}
						},
						_optionDatepicker : function(target, name, value) {
							var settings = name || {};
							if (typeof name == "string") {
								settings = {};
								settings[name] = value
							}
							var inst = this._getInst(target);
							if (inst) {
								if (this._curInst == inst) {
									this._hideDatepicker(null)
								}
								extendRemove(inst.settings, settings);
								var date = new Date();
								extendRemove(inst, {
									rangeStart : null,
									endDay : null,
									endMonth : null,
									endYear : null,
									selectedDay : date.getDate(),
									selectedMonth : date.getMonth(),
									selectedYear : date.getFullYear(),
									currentDay : date.getDate(),
									currentMonth : date.getMonth(),
									currentYear : date.getFullYear(),
									drawMonth : date.getMonth(),
									drawYear : date.getFullYear()
								});
								this._updateDatepicker(inst)
							}
						},
						_changeDatepicker : function(target, name, value) {
							this._optionDatepicker(target, name, value)
						},
						_refreshDatepicker : function(target) {
							var inst = this._getInst(target);
							if (inst) {
								this._updateDatepicker(inst)
							}
						},
						_setDateDatepicker : function(target, date, endDate) {
							var inst = this._getInst(target);
							if (inst) {
								this._setDate(inst, date, endDate);
								this._updateDatepicker(inst);
								this._updateAlternate(inst)
							}
						},
						_getDateDatepicker : function(target) {
							var inst = this._getInst(target);
							if (inst && !inst.inline) {
								this._setDateFromField(inst)
							}
							return (inst ? this._getDate(inst) : null)
						},
						_doKeyDown : function(event) {
							var inst = $.datepicker._getInst(event.target);
							var handled = true;
							var isRTL = inst.dpDiv.is(".ui-datepicker-rtl");
							inst._keyEvent = true;
							if ($.datepicker._datepickerShowing) {
								switch (event.keyCode) {
								case 9:
									$.datepicker._hideDatepicker(null, "");
									break;
								case 13:
									var sel = $("td."
											+ $.datepicker._dayOverClass
											+ ", td."
											+ $.datepicker._currentClass,
											inst.dpDiv);
									if (sel[0]) {
										$.datepicker._selectDay(event.target,
												inst.selectedMonth,
												inst.selectedYear, sel[0])
									} else {
										$.datepicker._hideDatepicker(null,
												$.datepicker._get(inst,
														"duration"))
									}
									return false;
									break;
								case 27:
									$.datepicker
											._hideDatepicker(null, $.datepicker
													._get(inst, "duration"));
									break;
								case 33:
									$.datepicker
											._adjustDate(
													event.target,
													(event.ctrlKey ? -$.datepicker
															._get(inst,
																	"stepBigMonths")
															: -$.datepicker
																	._get(inst,
																			"stepMonths")),
													"M");
									break;
								case 34:
									$.datepicker
											._adjustDate(
													event.target,
													(event.ctrlKey ? +$.datepicker
															._get(inst,
																	"stepBigMonths")
															: +$.datepicker
																	._get(inst,
																			"stepMonths")),
													"M");
									break;
								case 35:
									if (event.ctrlKey || event.metaKey) {
										$.datepicker._clearDate(event.target)
									}
									handled = event.ctrlKey || event.metaKey;
									break;
								case 36:
									if (event.ctrlKey || event.metaKey) {
										$.datepicker._gotoToday(event.target)
									}
									handled = event.ctrlKey || event.metaKey;
									break;
								case 37:
									if (event.ctrlKey || event.metaKey) {
										$.datepicker._adjustDate(event.target,
												(isRTL ? +1 : -1), "D")
									}
									handled = event.ctrlKey || event.metaKey;
									if (event.originalEvent.altKey) {
										$.datepicker
												._adjustDate(
														event.target,
														(event.ctrlKey ? -$.datepicker
																._get(inst,
																		"stepBigMonths")
																: -$.datepicker
																		._get(
																				inst,
																				"stepMonths")),
														"M")
									}
									break;
								case 38:
									if (event.ctrlKey || event.metaKey) {
										$.datepicker._adjustDate(event.target,
												-7, "D")
									}
									handled = event.ctrlKey || event.metaKey;
									break;
								case 39:
									if (event.ctrlKey || event.metaKey) {
										$.datepicker._adjustDate(event.target,
												(isRTL ? -1 : +1), "D")
									}
									handled = event.ctrlKey || event.metaKey;
									if (event.originalEvent.altKey) {
										$.datepicker
												._adjustDate(
														event.target,
														(event.ctrlKey ? +$.datepicker
																._get(inst,
																		"stepBigMonths")
																: +$.datepicker
																		._get(
																				inst,
																				"stepMonths")),
														"M")
									}
									break;
								case 40:
									if (event.ctrlKey || event.metaKey) {
										$.datepicker._adjustDate(event.target,
												+7, "D")
									}
									handled = event.ctrlKey || event.metaKey;
									break;
								default:
									handled = false
								}
							} else {
								if (event.keyCode == 36 && event.ctrlKey) {
									$.datepicker._showDatepicker(this)
								} else {
									handled = false
								}
							}
							if (handled) {
								event.preventDefault();
								event.stopPropagation()
							}
						},
						_doKeyPress : function(event) {
							var inst = $.datepicker._getInst(event.target);
							if ($.datepicker._get(inst, "constrainInput")) {
								var chars = $.datepicker
										._possibleChars($.datepicker._get(inst,
												"dateFormat"));
								var chr = String
										.fromCharCode(event.charCode == undefined ? event.keyCode
												: event.charCode);
								return event.ctrlKey
										|| (chr < " " || !chars || chars
												.indexOf(chr) > -1)
							}
						},
						_showDatepicker : function(input) {
							input = input.target || input;
							if (input.nodeName.toLowerCase() != "input") {
								input = $("input", input.parentNode)[0]
							}
							if ($.datepicker._isDisabledDatepicker(input)
									|| $.datepicker._lastInput == input) {
								return
							}
							var inst = $.datepicker._getInst(input);
							var beforeShow = $.datepicker._get(inst,
									"beforeShow");
							extendRemove(inst.settings,
									(beforeShow ? beforeShow.apply(input, [
											input, inst ]) : {}));
							$.datepicker._hideDatepicker(null, "");
							$.datepicker._lastInput = input;
							$.datepicker._setDateFromField(inst);
							if ($.datepicker._inDialog) {
								input.value = ""
							}
							if (!$.datepicker._pos) {
								$.datepicker._pos = $.datepicker
										._findPos(input);
								$.datepicker._pos[1] += input.offsetHeight
							}
							var isFixed = false;
							$(input).parents().each(function() {
								isFixed |= $(this).css("position") == "fixed";
								return !isFixed
							});
							if (isFixed && $.browser.opera) {
								$.datepicker._pos[0] -= document.documentElement.scrollLeft;
								$.datepicker._pos[1] -= document.documentElement.scrollTop
							}
							var offset = {
								left : $.datepicker._pos[0],
								top : $.datepicker._pos[1]
							};
							$.datepicker._pos = null;
							inst.rangeStart = null;
							inst.dpDiv.css( {
								position : "absolute",
								display : "block",
								top : "-1000px"
							});
							$.datepicker._updateDatepicker(inst);
							offset = $.datepicker._checkOffset(inst, offset,
									isFixed);
							inst.dpDiv
									.css( {
										position : ($.datepicker._inDialog
												&& $.blockUI ? "static"
												: (isFixed ? "fixed"
														: "absolute")),
										display : "none",
										left : offset.left + "px",
										top : offset.top + "px"
									});
							if (!inst.inline) {
								var showAnim = $.datepicker._get(inst,
										"showAnim")
										|| "show";
								var duration = $.datepicker._get(inst,
										"duration");
								var postProcess = function() {
									$.datepicker._datepickerShowing = true;
									if ($.browser.msie
											&& parseInt($.browser.version, 10) < 7) {
										$("iframe.ui-datepicker-cover").css( {
											width : inst.dpDiv.width() + 4,
											height : inst.dpDiv.height() + 4
										})
									}
								};
								if ($.effects && $.effects[showAnim]) {
									inst.dpDiv.show(showAnim, $.datepicker
											._get(inst, "showOptions"),
											duration, postProcess)
								} else {
									inst.dpDiv[showAnim](duration, postProcess)
								}
								if (duration == "") {
									postProcess()
								}
								if (inst.input[0].type != "hidden") {
									inst.input[0].focus()
								}
								$.datepicker._curInst = inst
							}
						},
						_updateDatepicker : function(inst) {
							var dims = {
								width : inst.dpDiv.width() + 4,
								height : inst.dpDiv.height() + 4
							};
							var self = this;
							inst.dpDiv
									.empty()
									.append(this._generateHTML(inst))
									.find("iframe.ui-datepicker-cover")
									.css( {
										width : dims.width,
										height : dims.height
									})
									.end()
									.find(
											"button, .ui-datepicker-prev, .ui-datepicker-next, .ui-datepicker-calendar td a")
									.bind(
											"mouseout",
											function() {
												$(this).removeClass(
														"ui-state-hover");
												if (this.className
														.indexOf("ui-datepicker-prev") != -1) {
													$(this)
															.removeClass(
																	"ui-datepicker-prev-hover")
												}
												if (this.className
														.indexOf("ui-datepicker-next") != -1) {
													$(this)
															.removeClass(
																	"ui-datepicker-next-hover")
												}
											})
									.bind(
											"mouseover",
											function() {
												if (!self
														._isDisabledDatepicker(inst.inline ? inst.dpDiv
																.parent()[0]
																: inst.input[0])) {
													$(this)
															.parents(
																	".ui-datepicker-calendar")
															.find("a")
															.removeClass(
																	"ui-state-hover");
													$(this).addClass(
															"ui-state-hover");
													if (this.className
															.indexOf("ui-datepicker-prev") != -1) {
														$(this)
																.addClass(
																		"ui-datepicker-prev-hover")
													}
													if (this.className
															.indexOf("ui-datepicker-next") != -1) {
														$(this)
																.addClass(
																		"ui-datepicker-next-hover")
													}
												}
											}).end().find(
											"." + this._dayOverClass + " a")
									.trigger("mouseover").end();
							var numMonths = this._getNumberOfMonths(inst);
							var cols = numMonths[1];
							var width = 17;
							if (cols > 1) {
								inst.dpDiv.addClass(
										"ui-datepicker-multi-" + cols).css(
										"width", (width * cols) + "em")
							} else {
								inst.dpDiv
										.removeClass(
												"ui-datepicker-multi-2 ui-datepicker-multi-3 ui-datepicker-multi-4")
										.width("")
							}
							inst.dpDiv[(numMonths[0] != 1 || numMonths[1] != 1 ? "add"
									: "remove")
									+ "Class"]("ui-datepicker-multi");
							inst.dpDiv[(this._get(inst, "isRTL") ? "add"
									: "remove")
									+ "Class"]("ui-datepicker-rtl");
							if (inst.input && inst.input[0].type != "hidden"
									&& inst == $.datepicker._curInst) {
								$(inst.input[0]).focus()
							}
						},
						_checkOffset : function(inst, offset, isFixed) {
							var dpWidth = inst.dpDiv.outerWidth();
							var dpHeight = inst.dpDiv.outerHeight();
							var inputWidth = inst.input ? inst.input
									.outerWidth() : 0;
							var inputHeight = inst.input ? inst.input
									.outerHeight() : 0;
							var viewWidth = (window.innerWidth
									|| document.documentElement.clientWidth || document.body.clientWidth)
									+ $(document).scrollLeft();
							var viewHeight = (window.innerHeight
									|| document.documentElement.clientHeight || document.body.clientHeight)
									+ $(document).scrollTop();
							offset.left -= (this._get(inst, "isRTL") ? (dpWidth - inputWidth)
									: 0);
							offset.left -= (isFixed && offset.left == inst.input
									.offset().left) ? $(document).scrollLeft()
									: 0;
							offset.top -= (isFixed && offset.top == (inst.input
									.offset().top + inputHeight)) ? $(document)
									.scrollTop() : 0;
							offset.left -= (offset.left + dpWidth > viewWidth && viewWidth > dpWidth) ? Math
									.abs(offset.left + dpWidth - viewWidth)
									: 0;
							offset.top -= (offset.top + dpHeight > viewHeight && viewHeight > dpHeight) ? Math
									.abs(offset.top + dpHeight + inputHeight
											* 2 - viewHeight)
									: 0;
							return offset
						},
						_findPos : function(obj) {
							while (obj
									&& (obj.type == "hidden" || obj.nodeType != 1)) {
								obj = obj.nextSibling
							}
							var position = $(obj).offset();
							return [ position.left, position.top ]
						},
						_hideDatepicker : function(input, duration) {
							var inst = this._curInst;
							if (!inst
									|| (input && inst != $.data(input,
											PROP_NAME))) {
								return
							}
							if (inst.stayOpen) {
								this._selectDate("#" + inst.id, this
										._formatDate(inst, inst.currentDay,
												inst.currentMonth,
												inst.currentYear))
							}
							inst.stayOpen = false;
							if (this._datepickerShowing) {
								duration = (duration != null ? duration : this
										._get(inst, "duration"));
								var showAnim = this._get(inst, "showAnim");
								var postProcess = function() {
									$.datepicker._tidyDialog(inst)
								};
								if (duration != "" && $.effects
										&& $.effects[showAnim]) {
									inst.dpDiv.hide(showAnim, $.datepicker
											._get(inst, "showOptions"),
											duration, postProcess)
								} else {
									inst.dpDiv[(duration == "" ? "hide"
											: (showAnim == "slideDown" ? "slideUp"
													: (showAnim == "fadeIn" ? "fadeOut"
															: "hide")))](
											duration, postProcess)
								}
								if (duration == "") {
									this._tidyDialog(inst)
								}
								var onClose = this._get(inst, "onClose");
								if (onClose) {
									onClose
											.apply(
													(inst.input ? inst.input[0]
															: null),
													[
															(inst.input ? inst.input
																	.val()
																	: ""), inst ])
								}
								this._datepickerShowing = false;
								this._lastInput = null;
								if (this._inDialog) {
									this._dialogInput.css( {
										position : "absolute",
										left : "0",
										top : "-100px"
									});
									if ($.blockUI) {
										$.unblockUI();
										$("body").append(this.dpDiv)
									}
								}
								this._inDialog = false
							}
							this._curInst = null
						},
						_tidyDialog : function(inst) {
							inst.dpDiv.removeClass(this._dialogClass).unbind(
									".ui-datepicker-calendar")
						},
						_checkExternalClick : function(event) {
							if (!$.datepicker._curInst) {
								return
							}
							var $target = $(event.target);
							if (($target.parents("#" + $.datepicker._mainDivId).length == 0)
									&& !$target
											.hasClass($.datepicker.markerClassName)
									&& !$target
											.hasClass($.datepicker._triggerClass)
									&& $.datepicker._datepickerShowing
									&& !($.datepicker._inDialog && $.blockUI)) {
								$.datepicker._hideDatepicker(null, "")
							}
						},
						_adjustDate : function(id, offset, period) {
							var target = $(id);
							var inst = this._getInst(target[0]);
							if (this._isDisabledDatepicker(target[0])) {
								return
							}
							this._adjustInstDate(inst, offset
									+ (period == "M" ? this._get(inst,
											"showCurrentAtPos") : 0), period);
							this._updateDatepicker(inst)
						},
						_gotoToday : function(id) {
							var target = $(id);
							var inst = this._getInst(target[0]);
							if (this._get(inst, "gotoCurrent")
									&& inst.currentDay) {
								inst.selectedDay = inst.currentDay;
								inst.drawMonth = inst.selectedMonth = inst.currentMonth;
								inst.drawYear = inst.selectedYear = inst.currentYear
							} else {
								var date = new Date();
								inst.selectedDay = date.getDate();
								inst.drawMonth = inst.selectedMonth = date
										.getMonth();
								inst.drawYear = inst.selectedYear = date
										.getFullYear()
							}
							this._notifyChange(inst);
							this._adjustDate(target)
						},
						_selectMonthYear : function(id, select, period) {
							var target = $(id);
							var inst = this._getInst(target[0]);
							inst._selectingMonthYear = false;
							inst["selected"
									+ (period == "M" ? "Month" : "Year")] = inst["draw"
									+ (period == "M" ? "Month" : "Year")] = parseInt(
									select.options[select.selectedIndex].value,
									10);
							this._notifyChange(inst);
							this._adjustDate(target)
						},
						_clickMonthYear : function(id) {
							var target = $(id);
							var inst = this._getInst(target[0]);
							if (inst.input && inst._selectingMonthYear
									&& !$.browser.msie) {
								inst.input[0].focus()
							}
							inst._selectingMonthYear = !inst._selectingMonthYear
						},
						_selectDay : function(id, month, year, td) {
							var target = $(id);
							if ($(td).hasClass(this._unselectableClass)
									|| this._isDisabledDatepicker(target[0])) {
								return
							}
							var inst = this._getInst(target[0]);
							inst.selectedDay = inst.currentDay = $("a", td)
									.html();
							inst.selectedMonth = inst.currentMonth = month;
							inst.selectedYear = inst.currentYear = year;
							if (inst.stayOpen) {
								inst.endDay = inst.endMonth = inst.endYear = null
							}
							this._selectDate(id, this._formatDate(inst,
									inst.currentDay, inst.currentMonth,
									inst.currentYear));
							if (inst.stayOpen) {
								inst.rangeStart = this
										._daylightSavingAdjust(new Date(
												inst.currentYear,
												inst.currentMonth,
												inst.currentDay));
								this._updateDatepicker(inst)
							}
						},
						_clearDate : function(id) {
							var target = $(id);
							var inst = this._getInst(target[0]);
							inst.stayOpen = false;
							inst.endDay = inst.endMonth = inst.endYear = inst.rangeStart = null;
							this._selectDate(target, "")
						},
						_selectDate : function(id, dateStr) {
							var target = $(id);
							var inst = this._getInst(target[0]);
							dateStr = (dateStr != null ? dateStr : this
									._formatDate(inst));
							if (inst.input) {
								inst.input.val(dateStr)
							}
							this._updateAlternate(inst);
							var onSelect = this._get(inst, "onSelect");
							if (onSelect) {
								onSelect.apply((inst.input ? inst.input[0]
										: null), [ dateStr, inst ])
							} else {
								if (inst.input) {
									inst.input.trigger("change")
								}
							}
							if (inst.inline) {
								this._updateDatepicker(inst)
							} else {
								if (!inst.stayOpen) {
									this._hideDatepicker(null, this._get(inst,
											"duration"));
									this._lastInput = inst.input[0];
									if (typeof (inst.input[0]) != "object") {
										inst.input[0].focus()
									}
									this._lastInput = null
								}
							}
						},
						_updateAlternate : function(inst) {
							var altField = this._get(inst, "altField");
							if (altField) {
								var altFormat = this._get(inst, "altFormat")
										|| this._get(inst, "dateFormat");
								var date = this._getDate(inst);
								dateStr = this.formatDate(altFormat, date, this
										._getFormatConfig(inst));
								$(altField).each(function() {
									$(this).val(dateStr)
								})
							}
						},
						noWeekends : function(date) {
							var day = date.getDay();
							return [ (day > 0 && day < 6), "" ]
						},
						iso8601Week : function(date) {
							var checkDate = new Date(date.getFullYear(), date
									.getMonth(), date.getDate());
							var firstMon = new Date(checkDate.getFullYear(),
									1 - 1, 4);
							var firstDay = firstMon.getDay() || 7;
							firstMon.setDate(firstMon.getDate() + 1 - firstDay);
							if (firstDay < 4 && checkDate < firstMon) {
								checkDate.setDate(checkDate.getDate() - 3);
								return $.datepicker.iso8601Week(checkDate)
							} else {
								if (checkDate > new Date(checkDate
										.getFullYear(), 12 - 1, 28)) {
									firstDay = new Date(
											checkDate.getFullYear() + 1, 1 - 1,
											4).getDay() || 7;
									if (firstDay > 4
											&& (checkDate.getDay() || 7) < firstDay - 3) {
										return 1
									}
								}
							}
							return Math
									.floor(((checkDate - firstMon) / 86400000) / 7) + 1
						},
						parseDate : function(format, value, settings) {
							if (format == null || value == null) {
								throw "Invalid arguments"
							}
							value = (typeof value == "object" ? value
									.toString() : value + "");
							if (value == "") {
								return null
							}
							var shortYearCutoff = (settings ? settings.shortYearCutoff
									: null)
									|| this._defaults.shortYearCutoff;
							var dayNamesShort = (settings ? settings.dayNamesShort
									: null)
									|| this._defaults.dayNamesShort;
							var dayNames = (settings ? settings.dayNames : null)
									|| this._defaults.dayNames;
							var monthNamesShort = (settings ? settings.monthNamesShort
									: null)
									|| this._defaults.monthNamesShort;
							var monthNames = (settings ? settings.monthNames
									: null)
									|| this._defaults.monthNames;
							var year = -1;
							var month = -1;
							var day = -1;
							var doy = -1;
							var literal = false;
							var lookAhead = function(match) {
								var matches = (iFormat + 1 < format.length && format
										.charAt(iFormat + 1) == match);
								if (matches) {
									iFormat++
								}
								return matches
							};
							var getNumber = function(match) {
								lookAhead(match);
								var origSize = (match == "@" ? 14
										: (match == "y" ? 4 : (match == "o" ? 3
												: 2)));
								var size = origSize;
								var num = 0;
								while (size > 0 && iValue < value.length
										&& value.charAt(iValue) >= "0"
										&& value.charAt(iValue) <= "9") {
									num = num
											* 10
											+ parseInt(value.charAt(iValue++),
													10);
									size--
								}
								if (size == origSize) {
									throw "Missing number at position "
											+ iValue
								}
								return num
							};
							var getName = function(match, shortNames, longNames) {
								var names = (lookAhead(match) ? longNames
										: shortNames);
								var size = 0;
								for ( var j = 0; j < names.length; j++) {
									size = Math.max(size, names[j].length)
								}
								var name = "";
								var iInit = iValue;
								while (size > 0 && iValue < value.length) {
									name += value.charAt(iValue++);
									for ( var i = 0; i < names.length; i++) {
										if (name == names[i]) {
											return i + 1
										}
									}
									size--
								}
								throw "Unknown name at position " + iInit
							};
							var checkLiteral = function() {
								if (value.charAt(iValue) != format
										.charAt(iFormat)) {
									throw "Unexpected literal at position "
											+ iValue
								}
								iValue++
							};
							var iValue = 0;
							for ( var iFormat = 0; iFormat < format.length; iFormat++) {
								if (literal) {
									if (format.charAt(iFormat) == "'"
											&& !lookAhead("'")) {
										literal = false
									} else {
										checkLiteral()
									}
								} else {
									switch (format.charAt(iFormat)) {
									case "d":
										day = getNumber("d");
										break;
									case "D":
										getName("D", dayNamesShort, dayNames);
										break;
									case "o":
										doy = getNumber("o");
										break;
									case "m":
										month = getNumber("m");
										break;
									case "M":
										month = getName("M", monthNamesShort,
												monthNames);
										break;
									case "y":
										year = getNumber("y");
										break;
									case "@":
										var date = new Date(getNumber("@"));
										year = date.getFullYear();
										month = date.getMonth() + 1;
										day = date.getDate();
										break;
									case "'":
										if (lookAhead("'")) {
											checkLiteral()
										} else {
											literal = true
										}
										break;
									default:
										checkLiteral()
									}
								}
							}
							if (year == -1) {
								year = new Date().getFullYear()
							} else {
								if (year < 100) {
									year += new Date().getFullYear()
											- new Date().getFullYear()
											% 100
											+ (year <= shortYearCutoff ? 0
													: -100)
								}
							}
							if (doy > -1) {
								month = 1;
								day = doy;
								do {
									var dim = this._getDaysInMonth(year,
											month - 1);
									if (day <= dim) {
										break
									}
									month++;
									day -= dim
								} while (true)
							}
							var date = this._daylightSavingAdjust(new Date(
									year, month - 1, day));
							if (date.getFullYear() != year
									|| date.getMonth() + 1 != month
									|| date.getDate() != day) {
								throw "Invalid date"
							}
							return date
						},
						ATOM : "yy-mm-dd",
						COOKIE : "D, dd M yy",
						ISO_8601 : "yy-mm-dd",
						RFC_822 : "D, d M y",
						RFC_850 : "DD, dd-M-y",
						RFC_1036 : "D, d M y",
						RFC_1123 : "D, d M yy",
						RFC_2822 : "D, d M yy",
						RSS : "D, d M y",
						TIMESTAMP : "@",
						W3C : "yy-mm-dd",
						formatDate : function(format, date, settings) {
							if (!date) {
								return ""
							}
							var dayNamesShort = (settings ? settings.dayNamesShort
									: null)
									|| this._defaults.dayNamesShort;
							var dayNames = (settings ? settings.dayNames : null)
									|| this._defaults.dayNames;
							var monthNamesShort = (settings ? settings.monthNamesShort
									: null)
									|| this._defaults.monthNamesShort;
							var monthNames = (settings ? settings.monthNames
									: null)
									|| this._defaults.monthNames;
							var lookAhead = function(match) {
								var matches = (iFormat + 1 < format.length && format
										.charAt(iFormat + 1) == match);
								if (matches) {
									iFormat++
								}
								return matches
							};
							var formatNumber = function(match, value, len) {
								var num = "" + value;
								if (lookAhead(match)) {
									while (num.length < len) {
										num = "0" + num
									}
								}
								return num
							};
							var formatName = function(match, value, shortNames,
									longNames) {
								return (lookAhead(match) ? longNames[value]
										: shortNames[value])
							};
							var output = "";
							var literal = false;
							if (date) {
								for ( var iFormat = 0; iFormat < format.length; iFormat++) {
									if (literal) {
										if (format.charAt(iFormat) == "'"
												&& !lookAhead("'")) {
											literal = false
										} else {
											output += format.charAt(iFormat)
										}
									} else {
										switch (format.charAt(iFormat)) {
										case "d":
											output += formatNumber("d", date
													.getDate(), 2);
											break;
										case "D":
											output += formatName("D", date
													.getDay(), dayNamesShort,
													dayNames);
											break;
										case "o":
											var doy = date.getDate();
											for ( var m = date.getMonth() - 1; m >= 0; m--) {
												doy += this._getDaysInMonth(
														date.getFullYear(), m)
											}
											output += formatNumber("o", doy, 3);
											break;
										case "m":
											output += formatNumber("m", date
													.getMonth() + 1, 2);
											break;
										case "M":
											output += formatName("M", date
													.getMonth(),
													monthNamesShort, monthNames);
											break;
										case "y":
											output += (lookAhead("y") ? date
													.getFullYear() : (date
													.getYear() % 100 < 10 ? "0"
													: "")
													+ date.getYear() % 100);
											break;
										case "@":
											output += date.getTime();
											break;
										case "'":
											if (lookAhead("'")) {
												output += "'"
											} else {
												literal = true
											}
											break;
										default:
											output += format.charAt(iFormat)
										}
									}
								}
							}
							return output
						},
						_possibleChars : function(format) {
							var chars = "";
							var literal = false;
							for ( var iFormat = 0; iFormat < format.length; iFormat++) {
								if (literal) {
									if (format.charAt(iFormat) == "'"
											&& !lookAhead("'")) {
										literal = false
									} else {
										chars += format.charAt(iFormat)
									}
								} else {
									switch (format.charAt(iFormat)) {
									case "d":
									case "m":
									case "y":
									case "@":
										chars += "0123456789";
										break;
									case "D":
									case "M":
										return null;
									case "'":
										if (lookAhead("'")) {
											chars += "'"
										} else {
											literal = true
										}
										break;
									default:
										chars += format.charAt(iFormat)
									}
								}
							}
							return chars
						},
						_get : function(inst, name) {
							return inst.settings[name] !== undefined ? inst.settings[name]
									: this._defaults[name]
						},
						_setDateFromField : function(inst) {
							var dateFormat = this._get(inst, "dateFormat");
							var dates = inst.input ? inst.input.val() : null;
							inst.endDay = inst.endMonth = inst.endYear = null;
							var date = defaultDate = this._getDefaultDate(inst);
							var settings = this._getFormatConfig(inst);
							try {
								date = this.parseDate(dateFormat, dates,
										settings)
										|| defaultDate
							} catch (event) {
								this.log(event);
								date = defaultDate
							}
							inst.selectedDay = date.getDate();
							inst.drawMonth = inst.selectedMonth = date
									.getMonth();
							inst.drawYear = inst.selectedYear = date
									.getFullYear();
							inst.currentDay = (dates ? date.getDate() : 0);
							inst.currentMonth = (dates ? date.getMonth() : 0);
							inst.currentYear = (dates ? date.getFullYear() : 0);
							this._adjustInstDate(inst)
						},
						_getDefaultDate : function(inst) {
							var date = this._determineDate(this._get(inst,
									"defaultDate"), new Date());
							var minDate = this
									._getMinMaxDate(inst, "min", true);
							var maxDate = this._getMinMaxDate(inst, "max");
							date = (minDate && date < minDate ? minDate : date);
							date = (maxDate && date > maxDate ? maxDate : date);
							return date
						},
						_determineDate : function(date, defaultDate) {
							var offsetNumeric = function(offset) {
								var date = new Date();
								date.setDate(date.getDate() + offset);
								return date
							};
							var offsetString = function(offset, getDaysInMonth) {
								var date = new Date();
								var year = date.getFullYear();
								var month = date.getMonth();
								var day = date.getDate();
								var pattern = /([+-]?[0-9]+)\s*(d|D|w|W|m|M|y|Y)?/g;
								var matches = pattern.exec(offset);
								while (matches) {
									switch (matches[2] || "d") {
									case "d":
									case "D":
										day += parseInt(matches[1], 10);
										break;
									case "w":
									case "W":
										day += parseInt(matches[1], 10) * 7;
										break;
									case "m":
									case "M":
										month += parseInt(matches[1], 10);
										day = Math.min(day, getDaysInMonth(
												year, month));
										break;
									case "y":
									case "Y":
										year += parseInt(matches[1], 10);
										day = Math.min(day, getDaysInMonth(
												year, month));
										break
									}
									matches = pattern.exec(offset)
								}
								return new Date(year, month, day)
							};
							date = (date == null ? defaultDate
									: (typeof date == "string" ? offsetString(
											date, this._getDaysInMonth)
											: (typeof date == "number" ? (isNaN(date) ? defaultDate
													: offsetNumeric(date))
													: date)));
							date = (date && date.toString() == "Invalid Date" ? defaultDate
									: date);
							if (date) {
								date.setHours(0);
								date.setMinutes(0);
								date.setSeconds(0);
								date.setMilliseconds(0)
							}
							return this._daylightSavingAdjust(date)
						},
						_daylightSavingAdjust : function(date) {
							if (!date) {
								return null
							}
							date.setHours(date.getHours() > 12 ? date
									.getHours() + 2 : 0);
							return date
						},
						_setDate : function(inst, date, endDate) {
							var clear = !(date);
							var origMonth = inst.selectedMonth;
							var origYear = inst.selectedYear;
							date = this._determineDate(date, new Date());
							inst.selectedDay = inst.currentDay = date.getDate();
							inst.drawMonth = inst.selectedMonth = inst.currentMonth = date
									.getMonth();
							inst.drawYear = inst.selectedYear = inst.currentYear = date
									.getFullYear();
							if (origMonth != inst.selectedMonth
									|| origYear != inst.selectedYear) {
								this._notifyChange(inst)
							}
							this._adjustInstDate(inst);
							if (inst.input) {
								inst.input.val(clear ? "" : this
										._formatDate(inst))
							}
						},
						_getDate : function(inst) {
							var startDate = (!inst.currentYear
									|| (inst.input && inst.input.val() == "") ? null
									: this
											._daylightSavingAdjust(new Date(
													inst.currentYear,
													inst.currentMonth,
													inst.currentDay)));
							return startDate
						},
						_generateHTML : function(inst) {
							var today = new Date();
							today = this._daylightSavingAdjust(new Date(today
									.getFullYear(), today.getMonth(), today
									.getDate()));
							var isRTL = this._get(inst, "isRTL");
							var showButtonPanel = this._get(inst,
									"showButtonPanel");
							var hideIfNoPrevNext = this._get(inst,
									"hideIfNoPrevNext");
							var navigationAsDateFormat = this._get(inst,
									"navigationAsDateFormat");
							var numMonths = this._getNumberOfMonths(inst);
							var showCurrentAtPos = this._get(inst,
									"showCurrentAtPos");
							var stepMonths = this._get(inst, "stepMonths");
							var stepBigMonths = this
									._get(inst, "stepBigMonths");
							var isMultiMonth = (numMonths[0] != 1 || numMonths[1] != 1);
							var currentDate = this
									._daylightSavingAdjust((!inst.currentDay ? new Date(
											9999, 9, 9)
											: new Date(inst.currentYear,
													inst.currentMonth,
													inst.currentDay)));
							var minDate = this
									._getMinMaxDate(inst, "min", true);
							var maxDate = this._getMinMaxDate(inst, "max");
							var drawMonth = inst.drawMonth - showCurrentAtPos;
							var drawYear = inst.drawYear;
							if (drawMonth < 0) {
								drawMonth += 12;
								drawYear--
							}
							if (maxDate) {
								var maxDraw = this
										._daylightSavingAdjust(new Date(maxDate
												.getFullYear(), maxDate
												.getMonth()
												- numMonths[1] + 1, maxDate
												.getDate()));
								maxDraw = (minDate && maxDraw < minDate ? minDate
										: maxDraw);
								while (this._daylightSavingAdjust(new Date(
										drawYear, drawMonth, 1)) > maxDraw) {
									drawMonth--;
									if (drawMonth < 0) {
										drawMonth = 11;
										drawYear--
									}
								}
							}
							inst.drawMonth = drawMonth;
							inst.drawYear = drawYear;
							var prevText = this._get(inst, "prevText");
							prevText = (!navigationAsDateFormat ? prevText
									: this.formatDate(prevText, this
											._daylightSavingAdjust(new Date(
													drawYear, drawMonth
															- stepMonths, 1)),
											this._getFormatConfig(inst)));
							var prev = (this._canAdjustMonth(inst, -1,
									drawYear, drawMonth) ? '<a class="ui-datepicker-prev ui-corner-all" onclick="DP_jQuery.datepicker._adjustDate(\'#'
									+ inst.id
									+ "', -"
									+ stepMonths
									+ ", 'M');\" title=\""
									+ prevText
									+ '"><span class="ui-icon ui-icon-circle-triangle-'
									+ (isRTL ? "e" : "w")
									+ '">'
									+ prevText
									+ "</span></a>"
									: (hideIfNoPrevNext ? ""
											: '<a class="ui-datepicker-prev ui-corner-all ui-state-disabled" title="'
													+ prevText
													+ '"><span class="ui-icon ui-icon-circle-triangle-'
													+ (isRTL ? "e" : "w")
													+ '">'
													+ prevText
													+ "</span></a>"));
							var nextText = this._get(inst, "nextText");
							nextText = (!navigationAsDateFormat ? nextText
									: this.formatDate(nextText, this
											._daylightSavingAdjust(new Date(
													drawYear, drawMonth
															+ stepMonths, 1)),
											this._getFormatConfig(inst)));
							var next = (this._canAdjustMonth(inst, +1,
									drawYear, drawMonth) ? '<a class="ui-datepicker-next ui-corner-all" onclick="DP_jQuery.datepicker._adjustDate(\'#'
									+ inst.id
									+ "', +"
									+ stepMonths
									+ ", 'M');\" title=\""
									+ nextText
									+ '"><span class="ui-icon ui-icon-circle-triangle-'
									+ (isRTL ? "w" : "e")
									+ '">'
									+ nextText
									+ "</span></a>"
									: (hideIfNoPrevNext ? ""
											: '<a class="ui-datepicker-next ui-corner-all ui-state-disabled" title="'
													+ nextText
													+ '"><span class="ui-icon ui-icon-circle-triangle-'
													+ (isRTL ? "w" : "e")
													+ '">'
													+ nextText
													+ "</span></a>"));
							var currentText = this._get(inst, "currentText");
							var gotoDate = (this._get(inst, "gotoCurrent")
									&& inst.currentDay ? currentDate : today);
							currentText = (!navigationAsDateFormat ? currentText
									: this.formatDate(currentText, gotoDate,
											this._getFormatConfig(inst)));
							var controls = (!inst.inline ? '<button type="button" class="ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all" onclick="DP_jQuery.datepicker._hideDatepicker();">'
									+ this._get(inst, "closeText")
									+ "</button>"
									: "");
							var buttonPanel = (showButtonPanel) ? '<div class="ui-datepicker-buttonpane ui-widget-content">'
									+ (isRTL ? controls : "")
									+ (this._isInRange(inst, gotoDate) ? '<button type="button" class="ui-datepicker-current ui-state-default ui-priority-secondary ui-corner-all" onclick="DP_jQuery.datepicker._gotoToday(\'#'
											+ inst.id
											+ "');\">"
											+ currentText
											+ "</button>"
											: "")
									+ (isRTL ? "" : controls)
									+ "</div>"
									: "";
							var firstDay = parseInt(
									this._get(inst, "firstDay"), 10);
							firstDay = (isNaN(firstDay) ? 0 : firstDay);
							var dayNames = this._get(inst, "dayNames");
							var dayNamesShort = this
									._get(inst, "dayNamesShort");
							var dayNamesMin = this._get(inst, "dayNamesMin");
							var monthNames = this._get(inst, "monthNames");
							var monthNamesShort = this._get(inst,
									"monthNamesShort");
							var beforeShowDay = this
									._get(inst, "beforeShowDay");
							var showOtherMonths = this._get(inst,
									"showOtherMonths");
							var calculateWeek = this
									._get(inst, "calculateWeek")
									|| this.iso8601Week;
							var endDate = inst.endDay ? this
									._daylightSavingAdjust(new Date(
											inst.endYear, inst.endMonth,
											inst.endDay)) : currentDate;
							var defaultDate = this._getDefaultDate(inst);
							var html = "";
							for ( var row = 0; row < numMonths[0]; row++) {
								var group = "";
								for ( var col = 0; col < numMonths[1]; col++) {
									var selectedDate = this
											._daylightSavingAdjust(new Date(
													drawYear, drawMonth,
													inst.selectedDay));
									var cornerClass = " ui-corner-all";
									var calender = "";
									if (isMultiMonth) {
										calender += '<div class="ui-datepicker-group ui-datepicker-group-';
										switch (col) {
										case 0:
											calender += "first";
											cornerClass = " ui-corner-"
													+ (isRTL ? "right" : "left");
											break;
										case numMonths[1] - 1:
											calender += "last";
											cornerClass = " ui-corner-"
													+ (isRTL ? "left" : "right");
											break;
										default:
											calender += "middle";
											cornerClass = "";
											break
										}
										calender += '">'
									}
									calender += '<div class="ui-datepicker-header ui-widget-header ui-helper-clearfix'
											+ cornerClass
											+ '">'
											+ (/all|left/.test(cornerClass)
													&& row == 0 ? (isRTL ? next
													: prev) : "")
											+ (/all|right/.test(cornerClass)
													&& row == 0 ? (isRTL ? prev
													: next) : "")
											+ this
													._generateMonthYearHeader(
															inst, drawMonth,
															drawYear, minDate,
															maxDate,
															selectedDate,
															row > 0 || col > 0,
															monthNames,
															monthNamesShort)
											+ '</div><table class="ui-datepicker-calendar"><thead><tr>';
									var thead = "";
									for ( var dow = 0; dow < 7; dow++) {
										var day = (dow + firstDay) % 7;
										thead += "<th"
												+ ((dow + firstDay + 6) % 7 >= 5 ? ' class="ui-datepicker-week-end"'
														: "")
												+ '><span title="'
												+ dayNames[day] + '">'
												+ dayNamesMin[day]
												+ "</span></th>"
									}
									calender += thead + "</tr></thead><tbody>";
									var daysInMonth = this._getDaysInMonth(
											drawYear, drawMonth);
									if (drawYear == inst.selectedYear
											&& drawMonth == inst.selectedMonth) {
										inst.selectedDay = Math.min(
												inst.selectedDay, daysInMonth)
									}
									var leadDays = (this._getFirstDayOfMonth(
											drawYear, drawMonth)
											- firstDay + 7) % 7;
									var numRows = (isMultiMonth ? 6 : Math
											.ceil((leadDays + daysInMonth) / 7));
									var printDate = this
											._daylightSavingAdjust(new Date(
													drawYear, drawMonth,
													1 - leadDays));
									for ( var dRow = 0; dRow < numRows; dRow++) {
										calender += "<tr>";
										var tbody = "";
										for ( var dow = 0; dow < 7; dow++) {
											var daySettings = (beforeShowDay ? beforeShowDay
													.apply(
															(inst.input ? inst.input[0]
																	: null),
															[ printDate ])
													: [ true, "" ]);
											var otherMonth = (printDate
													.getMonth() != drawMonth);
											var unselectable = otherMonth
													|| !daySettings[0]
													|| (minDate && printDate < minDate)
													|| (maxDate && printDate > maxDate);
											tbody += '<td class="'
													+ ((dow + firstDay + 6) % 7 >= 5 ? " ui-datepicker-week-end"
															: "")
													+ (otherMonth ? " ui-datepicker-other-month"
															: "")
													+ ((printDate.getTime() == selectedDate
															.getTime()
															&& drawMonth == inst.selectedMonth && inst._keyEvent)
															|| (defaultDate
																	.getTime() == printDate
																	.getTime() && defaultDate
																	.getTime() == selectedDate
																	.getTime()) ? " "
															+ this._dayOverClass
															: "")
													+ (unselectable ? " "
															+ this._unselectableClass
															+ " ui-state-disabled"
															: "")
													+ (otherMonth
															&& !showOtherMonths ? ""
															: " "
																	+ daySettings[1]
																	+ (printDate
																			.getTime() >= currentDate
																			.getTime()
																			&& printDate
																					.getTime() <= endDate
																					.getTime() ? " "
																			+ this._currentClass
																			: "")
																	+ (printDate
																			.getTime() == today
																			.getTime() ? " ui-datepicker-today"
																			: ""))
													+ '"'
													+ ((!otherMonth || showOtherMonths)
															&& daySettings[2] ? ' title="' + daySettings[2] + '"'
															: "")
													+ (unselectable ? ""
															: " onclick=\"DP_jQuery.datepicker._selectDay('#"
																	+ inst.id
																	+ "',"
																	+ drawMonth
																	+ ","
																	+ drawYear
																	+ ', this);return false;"')
													+ ">"
													+ (otherMonth ? (showOtherMonths ? printDate
															.getDate()
															: "&#xa0;")
															: (unselectable ? '<span class="ui-state-default">'
																	+ printDate
																			.getDate()
																	+ "</span>"
																	: '<a class="ui-state-default'
																			+ (printDate
																					.getTime() == today
																					.getTime() ? " ui-state-highlight"
																					: "")
																			+ (printDate
																					.getTime() >= currentDate
																					.getTime()
																					&& printDate
																							.getTime() <= endDate
																							.getTime() ? " ui-state-active"
																					: "")
																			+ '" href="#">'
																			+ printDate
																					.getDate()
																			+ "</a>"))
													+ "</td>";
											printDate.setDate(printDate
													.getDate() + 1);
											printDate = this
													._daylightSavingAdjust(printDate)
										}
										calender += tbody + "</tr>"
									}
									drawMonth++;
									if (drawMonth > 11) {
										drawMonth = 0;
										drawYear++
									}
									calender += "</tbody></table>"
											+ (isMultiMonth ? "</div>"
													+ ((numMonths[0] > 0 && col == numMonths[1] - 1) ? '<div class="ui-datepicker-row-break"></div>'
															: "")
													: "");
									group += calender
								}
								html += group
							}
							html += buttonPanel
									+ ($.browser.msie
											&& parseInt($.browser.version, 10) < 7
											&& !inst.inline ? '<iframe src="javascript:false;" class="ui-datepicker-cover" frameborder="0"></iframe>'
											: "");
							inst._keyEvent = false;
							return html
						},
						_generateMonthYearHeader : function(inst, drawMonth,
								drawYear, minDate, maxDate, selectedDate,
								secondary, monthNames, monthNamesShort) {
							minDate = (inst.rangeStart && minDate
									&& selectedDate < minDate ? selectedDate
									: minDate);
							var changeMonth = this._get(inst, "changeMonth");
							var changeYear = this._get(inst, "changeYear");
							var showMonthAfterYear = this._get(inst,
									"showMonthAfterYear");
							var html = '<div class="ui-datepicker-title">';
							var monthHtml = "";
							if (secondary || !changeMonth) {
								monthHtml += '<span class="ui-datepicker-month">'
										+ monthNames[drawMonth] + "</span> "
							} else {
								var inMinYear = (minDate && minDate
										.getFullYear() == drawYear);
								var inMaxYear = (maxDate && maxDate
										.getFullYear() == drawYear);
								monthHtml += '<select class="ui-datepicker-month" onchange="DP_jQuery.datepicker._selectMonthYear(\'#'
										+ inst.id
										+ "', this, 'M');\" onclick=\"DP_jQuery.datepicker._clickMonthYear('#"
										+ inst.id + "');\">";
								for ( var month = 0; month < 12; month++) {
									if ((!inMinYear || month >= minDate
											.getMonth())
											&& (!inMaxYear || month <= maxDate
													.getMonth())) {
										monthHtml += '<option value="'
												+ month
												+ '"'
												+ (month == drawMonth ? ' selected="selected"'
														: "") + ">"
												+ monthNamesShort[month]
												+ "</option>"
									}
								}
								monthHtml += "</select>"
							}
							if (!showMonthAfterYear) {
								html += monthHtml
										+ ((secondary || changeMonth || changeYear)
												&& (!(changeMonth && changeYear)) ? "&#xa0;"
												: "")
							}
							if (secondary || !changeYear) {
								html += '<span class="ui-datepicker-year">'
										+ drawYear + "</span>"
							} else {
								var years = this._get(inst, "yearRange").split(
										":");
								var year = 0;
								var endYear = 0;
								if (years.length != 2) {
									year = drawYear - 10;
									endYear = drawYear + 10
								} else {
									if (years[0].charAt(0) == "+"
											|| years[0].charAt(0) == "-") {
										year = drawYear
												+ parseInt(years[0], 10);
										endYear = drawYear
												+ parseInt(years[1], 10)
									} else {
										year = parseInt(years[0], 10);
										endYear = parseInt(years[1], 10)
									}
								}
								year = (minDate ? Math.max(year, minDate
										.getFullYear()) : year);
								endYear = (maxDate ? Math.min(endYear, maxDate
										.getFullYear()) : endYear);
								html += '<select class="ui-datepicker-year" onchange="DP_jQuery.datepicker._selectMonthYear(\'#'
										+ inst.id
										+ "', this, 'Y');\" onclick=\"DP_jQuery.datepicker._clickMonthYear('#"
										+ inst.id + "');\">";
								for (; year <= endYear; year++) {
									html += '<option value="'
											+ year
											+ '"'
											+ (year == drawYear ? ' selected="selected"'
													: "") + ">" + year
											+ "</option>"
								}
								html += "</select>"
							}
							if (showMonthAfterYear) {
								html += (secondary || changeMonth || changeYear ? "&#xa0;"
										: "")
										+ monthHtml
							}
							html += "</div>";
							return html
						},
						_adjustInstDate : function(inst, offset, period) {
							var year = inst.drawYear
									+ (period == "Y" ? offset : 0);
							var month = inst.drawMonth
									+ (period == "M" ? offset : 0);
							var day = Math.min(inst.selectedDay, this
									._getDaysInMonth(year, month))
									+ (period == "D" ? offset : 0);
							var date = this._daylightSavingAdjust(new Date(
									year, month, day));
							var minDate = this
									._getMinMaxDate(inst, "min", true);
							var maxDate = this._getMinMaxDate(inst, "max");
							date = (minDate && date < minDate ? minDate : date);
							date = (maxDate && date > maxDate ? maxDate : date);
							inst.selectedDay = date.getDate();
							inst.drawMonth = inst.selectedMonth = date
									.getMonth();
							inst.drawYear = inst.selectedYear = date
									.getFullYear();
							if (period == "M" || period == "Y") {
								this._notifyChange(inst)
							}
						},
						_notifyChange : function(inst) {
							var onChange = this._get(inst, "onChangeMonthYear");
							if (onChange) {
								onChange.apply((inst.input ? inst.input[0]
										: null), [ inst.selectedYear,
										inst.selectedMonth + 1, inst ])
							}
						},
						_getNumberOfMonths : function(inst) {
							var numMonths = this._get(inst, "numberOfMonths");
							return (numMonths == null ? [ 1, 1 ]
									: (typeof numMonths == "number" ? [ 1,
											numMonths ] : numMonths))
						},
						_getMinMaxDate : function(inst, minMax, checkRange) {
							var date = this._determineDate(this._get(inst,
									minMax + "Date"), null);
							return (!checkRange || !inst.rangeStart ? date
									: (!date || inst.rangeStart > date ? inst.rangeStart
											: date))
						},
						_getDaysInMonth : function(year, month) {
							return 32 - new Date(year, month, 32).getDate()
						},
						_getFirstDayOfMonth : function(year, month) {
							return new Date(year, month, 1).getDay()
						},
						_canAdjustMonth : function(inst, offset, curYear,
								curMonth) {
							var numMonths = this._getNumberOfMonths(inst);
							var date = this._daylightSavingAdjust(new Date(
									curYear, curMonth
											+ (offset < 0 ? offset
													: numMonths[1]), 1));
							if (offset < 0) {
								date.setDate(this._getDaysInMonth(date
										.getFullYear(), date.getMonth()))
							}
							return this._isInRange(inst, date)
						},
						_isInRange : function(inst, date) {
							var newMinDate = (!inst.rangeStart ? null : this
									._daylightSavingAdjust(new Date(
											inst.selectedYear,
											inst.selectedMonth,
											inst.selectedDay)));
							newMinDate = (newMinDate
									&& inst.rangeStart < newMinDate ? inst.rangeStart
									: newMinDate);
							var minDate = newMinDate
									|| this._getMinMaxDate(inst, "min");
							var maxDate = this._getMinMaxDate(inst, "max");
							return ((!minDate || date >= minDate) && (!maxDate || date <= maxDate))
						},
						_getFormatConfig : function(inst) {
							var shortYearCutoff = this._get(inst,
									"shortYearCutoff");
							shortYearCutoff = (typeof shortYearCutoff != "string" ? shortYearCutoff
									: new Date().getFullYear() % 100
											+ parseInt(shortYearCutoff, 10));
							return {
								shortYearCutoff : shortYearCutoff,
								dayNamesShort : this
										._get(inst, "dayNamesShort"),
								dayNames : this._get(inst, "dayNames"),
								monthNamesShort : this._get(inst,
										"monthNamesShort"),
								monthNames : this._get(inst, "monthNames")
							}
						},
						_formatDate : function(inst, day, month, year) {
							if (!day) {
								inst.currentDay = inst.selectedDay;
								inst.currentMonth = inst.selectedMonth;
								inst.currentYear = inst.selectedYear
							}
							var date = (day ? (typeof day == "object" ? day
									: this._daylightSavingAdjust(new Date(year,
											month, day)))
									: this
											._daylightSavingAdjust(new Date(
													inst.currentYear,
													inst.currentMonth,
													inst.currentDay)));
							return this.formatDate(this
									._get(inst, "dateFormat"), date, this
									._getFormatConfig(inst))
						}
					});
	function extendRemove(target, props) {
		$.extend(target, props);
		for ( var name in props) {
			if (props[name] == null || props[name] == undefined) {
				target[name] = props[name]
			}
		}
		return target
	}
	function isArray(a) {
		return (a && (($.browser.safari && typeof a == "object" && a.length) || (a.constructor && a.constructor
				.toString().match(/\Array\(\)/))))
	}
	$.fn.datepicker = function(options) {
		if (!$.datepicker.initialized) {
			$(document).mousedown($.datepicker._checkExternalClick)
					.find("body").append($.datepicker.dpDiv);
			$.datepicker.initialized = true
		}
		var otherArgs = Array.prototype.slice.call(arguments, 1);
		if (typeof options == "string"
				&& (options == "isDisabled" || options == "getDate")) {
			return $.datepicker["_" + options + "Datepicker"].apply(
					$.datepicker, [ this[0] ].concat(otherArgs))
		}
		return this.each(function() {
			typeof options == "string" ? $.datepicker["_" + options
					+ "Datepicker"].apply($.datepicker, [ this ]
					.concat(otherArgs)) : $.datepicker._attachDatepicker(this,
					options)
		})
	};
	$.datepicker = new Datepicker();
	$.datepicker.initialized = false;
	$.datepicker.uuid = new Date().getTime();
	$.datepicker.version = "1.7.1";
	window.DP_jQuery = $
})(jQuery);;