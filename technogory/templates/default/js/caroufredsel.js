/*	
 *	jQuery carouFredSel 3.2.1
 *	Demo's and documentation:
 *	caroufredsel.frebsite.nl
 *	
 *	Copyright (c) 2010 Fred Heusschen
 *	www.frebsite.nl
 *
 *	Dual licensed under the MIT and GPL licenses.
 *	http://en.wikipedia.org/wiki/MIT_License
 *	http://en.wikipedia.org/wiki/GNU_General_Public_License
 */

(function($) {
	$.fn.carouFredSel = function(o) {
		if (this.length == 0)
			return log('No element selected.');
		if (this.length > 1) {
			return this.each(function() {
				$(this).carouFredSel(o)
			})
		}
		this.init = function(o) {
			if (typeof o != 'object')
				o = {};
			if (typeof o.scroll == 'number') {
				if (o.scroll <= 50)
					o.scroll = {
						items : o.scroll
					};
				else
					o.scroll = {
						duration : o.scroll
					}
			} else {
				if (typeof o.scroll == 'string')
					o.scroll = {
						easing : o.scroll
					}
			}
			if (typeof o.items == 'number')
				o.items = {
					visible : o.items
				};
			else if (typeof o.items == 'string')
				o.items = {
					visible : o.items,
					width : o.items,
					height : o.items
				};
			opts = $.extend(true, {}, $.fn.carouFredSel.defaults, o);
			opts.padding = getPadding(opts.padding);
			opts.usePadding = (opts.padding[0] == 0 && opts.padding[1] == 0
					&& opts.padding[2] == 0 && opts.padding[3] == 0) ? false
					: true;
			direction = (opts.direction == 'up' || opts.direction == 'left') ? 'next'
					: 'prev';
			if (opts.direction == 'right' || opts.direction == 'left') {
				opts.dimentions = [ 'width', 'outerWidth', 'height',
						'outerHeight', 'left', 'top', 'marginRight',
						'innerWidth' ]
			} else {
				opts.dimentions = [ 'height', 'outerHeight', 'width',
						'outerWidth', 'top', 'left', 'marginBottom',
						'innerHeight' ];
				opts.padding = [ opts.padding[3], opts.padding[2],
						opts.padding[1], opts.padding[0] ]
			}
			if (opts[opts.dimentions[2]] == 'auto') {
				opts[opts.dimentions[2]] = getSizes(opts, getItems(j))[1];
				opts.items[opts.dimentions[2]] = 'auto'
			} else {
				if (!opts.items[opts.dimentions[2]]) {
					opts.items[opts.dimentions[2]] = getItems(j)[opts.dimentions[3]]
							(true)
				}
			}
			if (!opts.items[opts.dimentions[0]]) {
				opts.items[opts.dimentions[0]] = getItems(j)[opts.dimentions[1]]
						(true)
			}
			if (opts.items.visible == 'variable') {
				if (typeof opts[opts.dimentions[0]] == 'number') {
					opts.maxDimention = opts[opts.dimentions[0]];
					opts[opts.dimentions[0]] = null
				} else {
					opts.maxDimention = l.parent()[opts.dimentions[7]]()
				}
				if (typeof opts.items[opts.dimentions[0]] == 'number') {
					opts.items.visible = Math.floor(opts.maxDimention
							/ opts.items[opts.dimentions[0]])
				} else {
					varnumvisitem = true;
					opts.items.visible = 0
				}
			}
			if (typeof opts.items.minimum != 'number')
				opts.items.minimum = opts.items.visible;
			if (typeof opts.scroll.items != 'number')
				opts.scroll.items = opts.items.visible;
			if (typeof opts.scroll.duration != 'number')
				opts.scroll.duration = 500;
			opts.auto = getNaviObject(opts.auto, false, true);
			opts.prev = getNaviObject(opts.prev);
			opts.next = getNaviObject(opts.next);
			opts.pagination = getNaviObject(opts.pagination, true);
			opts.auto = $.extend({}, opts.scroll, opts.auto);
			opts.prev = $.extend({}, opts.scroll, opts.prev);
			opts.next = $.extend({}, opts.scroll, opts.next);
			opts.pagination = $.extend({}, opts.scroll, opts.pagination);
			if (typeof opts.pagination.keys != 'boolean')
				opts.pagination.keys = false;
			if (typeof opts.pagination.anchorBuilder != 'function')
				opts.pagination.anchorBuilder = $.fn.carouFredSel.pageAnchorBuilder;
			if (typeof opts.auto.play != 'boolean')
				opts.auto.play = true;
			if (typeof opts.auto.nap != 'boolean')
				opts.auto.nap = true;
			if (typeof opts.auto.delay != 'number')
				opts.auto.delay = 0;
			if (typeof opts.auto.pauseDuration != 'number')
				opts.auto.pauseDuration = (opts.auto.duration < 10) ? 2500
						: opts.auto.duration * 5
		};
		this.build = function() {
			l.css({
				position : 'relative',
				overflow : 'hidden'
			});
			j.data('cfs_origCss', {
				width : j.css('width'),
				height : j.css('height'),
				position : j.css('position'),
				top : j.css('top'),
				left : j.css('left')
			}).css({
				position : 'absolute'
			});
			if (opts.usePadding) {
				getItems(j).each(function() {
					var m = parseInt($(this).css(opts.dimentions[6]));
					if (isNaN(m))
						m = 0;
					$(this).data('cfs_origCssMargin', m)
				})
			}
			showNavi(opts, totalItems)
		};
		this.bind_events = function() {
			j.bind('pause', function(e, g) {
				if (typeof g != 'boolean')
					g = false;
				if (g)
					pausedGlobal = true;
				if (autoTimeout != null) {
					clearTimeout(autoTimeout)
				}
				if (autoInterval != null) {
					clearInterval(autoInterval)
				}
			});
			j.bind('play', function(e, d, f, g) {
				j.trigger('pause');
				if (opts.auto.play) {
					if (typeof g != 'boolean') {
						if (typeof f == 'boolean')
							g = f;
						else if (typeof d == 'boolean')
							g = d;
						else
							g = false
					}
					if (typeof f != 'number') {
						if (typeof d == 'number')
							f = d;
						else
							f = 0
					}
					if (d != 'prev' && d != 'next')
						d = direction;
					if (g)
						pausedGlobal = false;
					if (pausedGlobal)
						return;
					autoTimeout = setTimeout(function() {
						if (j.is(':animated')) {
							j.trigger('play', d)
						} else {
							pauseTimePassed = 0;
							j.trigger(d, opts.auto)
						}
					}, opts.auto.pauseDuration + f - pauseTimePassed);
					if (opts.auto.pauseOnHover === 'resume') {
						autoInterval = setInterval(function() {
							pauseTimePassed += 100
						}, 100)
					}
				}
			});
			if (varnumvisitem) {
				j
						.bind(
								'prev',
								function(e, b, c) {
									if (j.is(':animated'))
										return;
									if (pausedGlobal)
										return;
									var d = getItems(j), total = 0, x = 0;
									if (typeof b == 'number')
										c = b;
									if (typeof c != 'number') {
										for ( var a = d.length - 1; a >= 0; a--) {
											current = d
													.filter(':eq(' + a + ')')[opts.dimentions[1]]
													(true);
											if (total + current > opts.maxDimention)
												break;
											total += current;
											x++
										}
										c = x
									}
									for ( var a = d.length - c; a < d.length; a++) {
										current = d.filter(':eq(' + a + ')')[opts.dimentions[1]]
												(true);
										if (total + current > opts.maxDimention)
											break;
										total += current;
										if (a == d.length - 1)
											a = 0;
										x++
									}
									;
									opts.items.visible = x;
									j.trigger('scrollPrev', [ b, c ])
								});
				j
						.bind(
								'next',
								function(e, b, c) {
									if (j.is(':animated'))
										return;
									if (pausedGlobal)
										return;
									var d = getItems(j), total = 0, x = 0;
									if (typeof b == 'number')
										c = b;
									if (typeof c != 'number')
										c = opts.items.visible;
									for ( var a = c; a < d.length; a++) {
										current = d.filter(':eq(' + a + ')')[opts.dimentions[1]]
												(true);
										if (total + current > opts.maxDimention)
											break;
										total += current;
										if (a == d.length - 1)
											a = 0;
										x++
									}
									;
									opts.items.visible = x;
									j.trigger('scrollNext', [ b, c ])
								}).trigger('next', {
							duration : 0
						})
			} else {
				j.bind('prev', function(e, a, b) {
					j.trigger('scrollPrev', [ a, b ])
				});
				j.bind('next', function(e, a, b) {
					j.trigger('scrollNext', [ a, b ])
				})
			}
			j
					.bind(
							'scrollPrev',
							function(e, b, c) {
								if (j.is(':animated'))
									return;
								if (pausedGlobal)
									return;
								if (opts.items.minimum >= totalItems)
									return log('Not enough items: not scrolling');
								if (typeof b == 'number')
									c = b;
								if (typeof b != 'object')
									b = opts.prev;
								if (typeof c != 'number')
									c = b.items;
								if (typeof c != 'number')
									return log('Not a valid number: not scrolling');
								if (!opts.circular) {
									var d = totalItems - firstItem;
									if (d - c < 0) {
										c = d
									}
									if (firstItem == 0) {
										c = 0
									}
								}
								firstItem += c;
								if (firstItem >= totalItems)
									firstItem -= totalItems;
								if (!opts.circular) {
									if (firstItem == 0 && c != 0
											&& opts.prev.onEnd) {
										opts.prev.onEnd()
									}
									if (opts.infinite) {
										if (c == 0) {
											j.trigger('next', totalItems
													- opts.items.visible);
											return false
										}
									} else {
										if (firstItem == 0 && opts.prev.button)
											opts.prev.button
													.addClass('disabled');
										if (opts.next.button)
											opts.next.button
													.removeClass('disabled')
									}
								}
								if (c == 0) {
									return false
								}
								getItems(j, ':gt(' + (totalItems - c - 1) + ')')
										.prependTo(j);
								if (totalItems < opts.items.visible + c)
									getItems(
											j,
											':lt('
													+ ((opts.items.visible + c) - totalItems)
													+ ')').clone(true)
											.appendTo(j);
								var f = getCurrentItems(j, opts, c), l_cur = getItems(
										j, ':nth(' + (c - 1) + ')'), l_old = f[1]
										.filter(':last'), l_new = f[0]
										.filter(':last');
								if (opts.usePadding)
									l_old.css(opts.dimentions[6], l_old
											.data('cfs_origCssMargin'));
								var g = getSizes(opts, getItems(j, ':lt(' + c
										+ ')')), w_siz = mapWrapperSizes(
										getSizes(opts, f[0], true), opts);
								if (opts.usePadding)
									l_old.css(opts.dimentions[6], l_old
											.data('cfs_origCssMargin')
											+ opts.padding[1]);
								var h = {}, a_new = {}, a_cur = {}, a_dur = b.duration;
								if (a_dur == 'auto')
									a_dur = opts.scroll.duration
											/ opts.scroll.items * c;
								else if (a_dur <= 0)
									a_dur = 0;
								else if (a_dur < 10)
									a_dur = g[0] / a_dur;
								if (b.onBefore)
									b.onBefore(f[1], f[0], w_siz, a_dur);
								if (opts.usePadding) {
									var i = opts.padding[3];
									a_cur[opts.dimentions[6]] = l_cur
											.data('cfs_origCssMargin');
									a_new[opts.dimentions[6]] = l_new
											.data('cfs_origCssMargin')
											+ opts.padding[1];
									l_cur.css(opts.dimentions[6], l_cur
											.data('cfs_origCssMargin')
											+ opts.padding[3]);
									l_cur.stop().animate(a_cur, {
										duration : a_dur,
										easing : b.easing
									});
									l_new.stop().animate(a_new, {
										duration : a_dur,
										easing : b.easing
									})
								} else {
									var i = 0
								}
								h[opts.dimentions[4]] = i;
								if ((typeof opts[opts.dimentions[0]] != 'number' && typeof opts.items[opts.dimentions[0]] != 'number')
										|| (typeof opts[opts.dimentions[2]] != 'number' && typeof opts.items[opts.dimentions[2]] != 'number')) {
									l.stop().animate(w_siz, {
										duration : a_dur,
										easing : b.easing
									})
								}
								j
										.data('cfs_numItems', c)
										.data('cfs_slideObj', b)
										.data('cfs_oldItems', f[1])
										.data('cfs_newItems', f[0])
										.data('cfs_wrapSize', w_siz)
										.css(opts.dimentions[4], -g[0])
										.animate(
												h,
												{
													duration : a_dur,
													easing : b.easing,
													complete : function() {
														if (j
																.data('cfs_slideObj').onAfter) {
															j
																	.data(
																			'cfs_slideObj')
																	.onAfter(
																			j
																					.data('cfs_oldItems'),
																			j
																					.data('cfs_newItems'),
																			j
																					.data('cfs_wrapSize'))
														}
														if (totalItems < opts.items.visible
																+ j
																		.data('cfs_numItems')) {
															getItems(
																	j,
																	':gt('
																			+ (totalItems - 1)
																			+ ')')
																	.remove()
														}
														var a = getItems(
																j,
																':nth('
																		+ (opts.items.visible
																				+ j
																						.data('cfs_numItems') - 1)
																		+ ')');
														if (opts.usePadding) {
															a
																	.css(
																			opts.dimentions[6],
																			a
																					.data('cfs_origCssMargin'))
														}
													}
												});
								j.trigger('updatePageStatus').trigger('play',
										a_dur)
							});
			j
					.bind(
							'scrollNext',
							function(e, c, d) {
								if (j.is(':animated'))
									return;
								if (pausedGlobal)
									return;
								if (opts.items.minimum >= totalItems)
									return log('Not enough items: not scrolling');
								if (typeof c == 'number')
									d = c;
								if (typeof c != 'object')
									c = opts.next;
								if (typeof d != 'number')
									d = c.items;
								if (typeof d != 'number')
									return log('Not a valid number: not scrolling');
								if (!opts.circular) {
									if (firstItem == 0) {
										if (d > totalItems - opts.items.visible) {
											d = totalItems - opts.items.visible
										}
									} else {
										if (firstItem - d < opts.items.visible) {
											d = firstItem - opts.items.visible
										}
									}
								}
								firstItem -= d;
								if (firstItem < 0)
									firstItem += totalItems;
								if (!opts.circular) {
									if (firstItem == opts.items.visible
											&& d != 0 && opts.next.onEnd) {
										opts.next.onEnd()
									}
									if (opts.infinite) {
										if (d == 0) {
											j.trigger('prev', totalItems
													- opts.items.visible);
											return false
										}
									} else {
										if (firstItem == opts.items.visible
												&& opts.next.button)
											opts.next.button
													.addClass('disabled');
										if (opts.prev.button)
											opts.prev.button
													.removeClass('disabled')
									}
								}
								if (d == 0) {
									return false
								}
								if (totalItems < opts.items.visible + d)
									getItems(
											j,
											':lt('
													+ ((opts.items.visible + d) - totalItems)
													+ ')').clone(true)
											.appendTo(j);
								var f = getCurrentItems(j, opts, d), l_cur = getItems(
										j, ':nth(' + (d - 1) + ')'), l_old = f[0]
										.filter(':last'), l_new = f[1]
										.filter(':last');
								if (opts.usePadding) {
									l_old.css(opts.dimentions[6], l_old
											.data('cfs_origCssMargin'));
									l_new.css(opts.dimentions[6], l_new
											.data('cfs_origCssMargin'))
								}
								var g = getSizes(opts, getItems(j, ':lt(' + d
										+ ')')), w_siz = mapWrapperSizes(
										getSizes(opts, f[1], true), opts);
								if (opts.usePadding) {
									l_old.css(opts.dimentions[6], l_old
											.data('cfs_origCssMargin')
											+ opts.padding[1]);
									l_new.css(opts.dimentions[6], l_new
											.data('cfs_origCssMargin')
											+ opts.padding[1])
								}
								var h = {}, a_old = {}, a_cur = {}, a_dur = c.duration;
								if (a_dur == 'auto')
									a_dur = opts.scroll.duration
											/ opts.scroll.items * d;
								else if (a_dur <= 0)
									a_dur = 0;
								else if (a_dur < 10)
									a_dur = g[0] / a_dur;
								if (c.onBefore)
									c.onBefore(f[0], f[1], w_siz, a_dur);
								h[opts.dimentions[4]] = -g[0];
								if (opts.usePadding) {
									a_old[opts.dimentions[6]] = l_old
											.data('cfs_origCssMargin');
									a_cur[opts.dimentions[6]] = l_cur
											.data('cfs_origCssMargin')
											+ opts.padding[3];
									l_new.css(opts.dimentions[6], l_new
											.data('cfs_origCssMargin')
											+ opts.padding[1]);
									l_old.stop().animate(a_old, {
										duration : a_dur,
										easing : c.easing
									});
									l_cur.stop().animate(a_cur, {
										duration : a_dur,
										easing : c.easing
									})
								}
								if ((typeof opts[opts.dimentions[0]] != 'number' && typeof opts.items[opts.dimentions[0]] != 'number')
										|| (typeof opts[opts.dimentions[2]] != 'number' && typeof opts.items[opts.dimentions[2]] != 'number')) {
									l.stop().animate(w_siz, {
										duration : a_dur,
										easing : c.easing
									})
								}
								j
										.data('cfs_numItems', d)
										.data('cfs_slideObj', c)
										.data('cfs_oldItems', f[0])
										.data('cfs_newItems', f[1])
										.data('cfs_wrapSize', w_siz)
										.animate(
												h,
												{
													duration : a_dur,
													easing : c.easing,
													complete : function() {
														if (j
																.data('cfs_slideObj').onAfter) {
															j
																	.data(
																			'cfs_slideObj')
																	.onAfter(
																			j
																					.data('cfs_oldItems'),
																			j
																					.data('cfs_newItems'),
																			j
																					.data('cfs_wrapSize'))
														}
														if (totalItems < opts.items.visible
																+ j
																		.data('cfs_numItems')) {
															getItems(
																	j,
																	':gt('
																			+ (totalItems - 1)
																			+ ')')
																	.remove()
														}
														var a = (opts.usePadding) ? opts.padding[3]
																: 0;
														j
																.css(
																		opts.dimentions[4],
																		a);
														var b = getItems(
																j,
																':lt('
																		+ j
																				.data('cfs_numItems')
																		+ ')')
																.appendTo(j)
																.filter(':last');
														if (opts.usePadding) {
															b
																	.css(
																			opts.dimentions[6],
																			b
																					.data('cfs_origCssMargin'))
														}
													}
												});
								j.trigger('updatePageStatus').trigger('play',
										a_dur)
							});
			j
					.bind('slideTo', function(e, a, b, c, d) {
						if (j.is(':animated'))
							return false;
						a = getItemIndex(a, b, c, firstItem, totalItems, j);
						if (a == 0)
							return false;
						if (typeof d != 'object')
							d = false;
						if (opts.circular) {
							if (a < totalItems / 2)
								j.trigger('next', [ d, a ]);
							else
								j.trigger('prev', [ d, totalItems - a ])
						} else {
							if (firstItem == 0 || firstItem > a)
								j.trigger('next', [ d, a ]);
							else
								j.trigger('prev', [ d, totalItems - a ])
						}
					})
					.bind(
							'insertItem',
							function(e, a, b, c, d) {
								if (typeof a == 'object'
										&& typeof a.jquery == 'undefined')
									a = $(a);
								if (typeof a == 'string')
									a = $(a);
								if (typeof a != 'object'
										|| typeof a.jquery == 'undefined'
										|| a.length == 0)
									return log('Not a valid object.');
								if (typeof b == 'undefined' || b == 'end') {
									j.append(a)
								} else {
									b = getItemIndex(b, d, c, firstItem,
											totalItems, j);
									var f = getItems(j, ':nth(' + b + ')');
									if (f.length) {
										if (b <= firstItem)
											firstItem += a.length;
										f.before(a)
									} else {
										j.append(a)
									}
								}
								totalItems = getItems(j).length;
								link_anchors('', '.caroufredsel', j);
								setSizes(j, opts);
								showNavi(opts, totalItems);
								j.trigger('updatePageStatus', true)
							})
					.bind(
							'removeItem',
							function(e, a, b, c) {
								if (typeof a == 'undefined' || a == 'end') {
									getItems(j, ':last').remove()
								} else {
									a = getItemIndex(a, c, b, firstItem,
											totalItems, j);
									var d = getItems(j, ':nth(' + a + ')');
									if (d.length) {
										if (a < firstItem)
											firstItem -= d.length;
										d.remove()
									}
								}
								totalItems = getItems(j).length;
								link_anchors('', '.caroufredsel', j);
								setSizes(j, opts);
								showNavi(opts, totalItems);
								j.trigger('updatePageStatus', true)
							})
					.bind(
							'updatePageStatus',
							function(e, b) {
								if (!opts.pagination.container)
									return false;
								if (typeof b == 'boolean' && b) {
									getItems(opts.pagination.container)
											.remove();
									for ( var a = 0; a < Math.ceil(totalItems
											/ opts.items.visible); a++) {
										opts.pagination.container
												.append(opts.pagination
														.anchorBuilder(a + 1))
									}
									getItems(opts.pagination.container)
											.unbind('click')
											.each(
													function(a) {
														$(this)
																.click(
																		function(
																				e) {
																			e
																					.preventDefault();
																			j
																					.trigger(
																							'slideTo',
																							[
																									a
																											* opts.items.visible,
																									0,
																									true,
																									opts.pagination ])
																		})
													})
								}
								var c = (firstItem == 0) ? 0 : Math
										.round((totalItems - firstItem)
												/ opts.items.visible);
								getItems(opts.pagination.container)
										.removeClass('selected').filter(
												':nth(' + c + ')').addClass(
												'selected')
							})
		};
		this.bind_buttons = function() {
			if (opts.auto.pauseOnHover && opts.auto.play) {
				l.hover(function() {
					j.trigger('pause')
				}, function() {
					j.trigger('play')
				})
			}
			if (opts.prev.button) {
				opts.prev.button.click(function(e) {
					j.trigger('prev');
					e.preventDefault()
				});
				if (opts.prev.pauseOnHover && opts.auto.play) {
					opts.prev.button.hover(function() {
						j.trigger('pause')
					}, function() {
						j.trigger('play')
					})
				}
				if (!opts.circular && !opts.infinite) {
					opts.prev.button.addClass('disabled')
				}
			}
			if ($.fn.mousewheel) {
				if (opts.prev.mousewheel) {
					l
							.mousewheel(function(e, a) {
								if (a > 0) {
									e.preventDefault();
									num = (typeof opts.prev.mousewheel == 'number') ? opts.prev.mousewheel
											: '';
									j.trigger('prev', num)
								}
							})
				}
				if (opts.next.mousewheel) {
					l
							.mousewheel(function(e, a) {
								if (a < 0) {
									e.preventDefault();
									num = (typeof opts.next.mousewheel == 'number') ? opts.next.mousewheel
											: '';
									j.trigger('next', num)
								}
							})
				}
			}
			if (opts.next.button) {
				opts.next.button.click(function(e) {
					e.preventDefault();
					j.trigger('next')
				});
				if (opts.next.pauseOnHover && opts.auto.play) {
					opts.next.button.hover(function() {
						j.trigger('pause')
					}, function() {
						j.trigger('play')
					})
				}
			}
			if (opts.pagination.container) {
				j.trigger('updatePageStatus', true);
				if (opts.pagination.pauseOnHover && opts.auto.play) {
					opts.pagination.container.hover(function() {
						j.trigger('pause')
					}, function() {
						j.trigger('play')
					})
				}
			}
			if (opts.next.key || opts.prev.key) {
				$(document).keyup(function(e) {
					var k = e.keyCode;
					if (k == opts.next.key) {
						e.preventDefault();
						j.trigger('next')
					}
					if (k == opts.prev.key) {
						e.preventDefault();
						j.trigger('prev')
					}
				})
			}
			if (opts.pagination.keys) {
				$(document).keyup(
						function(e) {
							var k = e.keyCode;
							if (k >= 49 && k < 58) {
								k = (k - 49) * opts.items.visible;
								if (k <= totalItems) {
									e.preventDefault();
									j.trigger('slideTo', [ k, 0, true,
											opts.pagination ])
								}
							}
						})
			}
			if (opts.auto.play) {
				j.trigger('play', opts.auto.delay);
				if ($.fn.nap && opts.auto.nap) {
					j.nap('pause', 'play')
				}
			}
		};
		this.destroy = function() {
			j.trigger('pause').css(j.data('cfs_origCss')).unbind('pause')
					.unbind('play').unbind('prev').unbind('next').unbind(
							'scrollTo').unbind('slideTo').unbind('insertItem')
					.unbind('removeItem').unbind('updatePageStatus');
			l.replaceWith(j);
			return this
		};
		this.configuration = function(a, b) {
			if (typeof a == 'undefined')
				return opts;
			if (typeof b == 'undefined') {
				var r = eval('opts.' + a);
				if (typeof r == 'undefined')
					r = '';
				return r
			}
			eval('opts.' + a + ' = b');
			this.init(opts);
			setSizes(j, opts);
			return this
		};
		this.link_anchors = function(a, b) {
			link_anchors(a, b, j)
		};
		this.current_position = function() {
			if (firstItem == 0) {
				return 0
			}
			return totalItems - firstItem
		};
		var j = $(this);
		if ($(this).parent().is('.caroufredsel_wrapper')) {
			var l = j.parent();
			this.destroy()
		}
		var l = $(this).wrap('<div class="caroufredsel_wrapper" />').parent(), opts = {}, totalItems = getItems(j).length, firstItem = 0, autoTimeout = null, autoInterval = null, pauseTimePassed = 0, pausedGlobal = false, direction = 'next', varnumvisitem = false;
		this.init(o);
		this.build();
		this.bind_events();
		this.bind_buttons();
		link_anchors('', '.caroufredsel', j);
		setSizes(j, opts);
		if (opts.items.start !== 0 && opts.items.start !== false) {
			var s = opts.items.start;
			if (opts.items.start === true) {
				s = window.location.hash;
				if (!s.length)
					s = 0
			}
			j.trigger('slideTo', [ s, 0, true, {
				duration : 0
			} ])
		}
		return this
	};
	$.fn.carouFredSel.defaults = {
		infinite : true,
		circular : true,
		direction : 'left',
		padding : 0,
		items : {
			visible : 5,
			start : 0
		},
		scroll : {
			easing : 'swing',
			pauseOnHover : false,
			mousewheel : false
		}
	};
	$.fn.carouFredSel.pageAnchorBuilder = function(a) {
		return '<a href="#"><span>' + a + '</span></a>'
	};
	function link_anchors(a, b, c) {
		if (typeof a == 'undefined' || a.length == 0)
			a = $('body');
		else if (typeof a == 'string')
			a = $(a);
		if (typeof a != 'object')
			return false;
		if (typeof b == 'undefined')
			b = '';
		a.find('a' + b).each(function() {
			var h = this.hash || '';
			if (h.length > 0 && getItems(c).index($(h)) != -1) {
				$(this).unbind('click').click(function(e) {
					e.preventDefault();
					c.trigger('slideTo', h)
				})
			}
		})
	}
	function showNavi(o, t) {
		if (o.items.minimum >= t) {
			log('Not enough items: not scrolling');
			var f = 'hide'
		} else {
			var f = 'show'
		}
		if (o.prev.button)
			o.prev.button[f]();
		if (o.next.button)
			o.next.button[f]();
		if (o.pagination.container)
			o.pagination.container[f]()
	}
	function getKeyCode(k) {
		if (k == 'right')
			return 39;
		if (k == 'left')
			return 37;
		if (k == 'up')
			return 38;
		if (k == 'down')
			return 40;
		return -1
	}
	;
	function getNaviObject(a, b, c) {
		if (typeof b != 'boolean')
			b = false;
		if (typeof c != 'boolean')
			c = false;
		if (typeof a == 'undefined')
			a = {};
		if (typeof a == 'string') {
			var d = getKeyCode(a);
			if (d == -1)
				a = $(a);
			else
				a = d
		}
		if (b) {
			if (typeof a.jquery != 'undefined')
				a = {
					container : a
				};
			if (typeof Object == 'boolean')
				a = {
					keys : a
				};
			if (typeof a.container == 'string')
				a.container = $(a.container)
		} else if (c) {
			if (typeof a == 'boolean')
				a = {
					play : a
				};
			if (typeof a == 'number')
				a = {
					pauseDuration : a
				}
		} else {
			if (typeof a.jquery != 'undefined')
				a = {
					button : a
				};
			if (typeof a == 'number')
				a = {
					key : a
				};
			if (typeof a.button == 'string')
				a.button = $(a.button);
			if (typeof a.key == 'string')
				a.key = getKeyCode(a.key)
		}
		return a
	}
	;
	function getItems(a, f) {
		if (typeof f != 'string')
			f = '';
		return $('> *' + f, a)
	}
	;
	function getCurrentItems(c, o, n) {
		var a = getItems(c, ':lt(' + o.items.visible + ')'), ni = getItems(c,
				':lt(' + (o.items.visible + n) + '):gt(' + (n - 1) + ')');
		return [ a, ni ]
	}
	;
	function getItemIndex(a, b, c, d, e, f) {
		if (typeof a == 'string') {
			if (isNaN(a))
				a = $(a);
			else
				a = parseInt(a)
		}
		if (typeof a == 'object') {
			if (typeof a.jquery == 'undefined')
				a = $(a);
			a = getItems(f).index(a);
			if (a == -1)
				a = 0;
			if (typeof c != 'boolean')
				c = false
		} else {
			if (typeof c != 'boolean')
				c = true
		}
		if (isNaN(a))
			a = 0;
		else
			a = parseInt(a);
		if (isNaN(b))
			b = 0;
		else
			b = parseInt(b);
		if (c) {
			a += d
		}
		a += b;
		if (e > 0) {
			while (a >= e) {
				a -= e
			}
			while (a < 0) {
				a += e
			}
		}
		return a
	}
	;
	function getSizes(o, a, b) {
		if (typeof b != 'boolean')
			b = false;
		var c = o.dimentions, s1 = 0, s2 = 0;
		if (b && typeof o[c[0]] == 'number')
			s1 += o[c[0]];
		else if (typeof o.items[c[0]] == 'number')
			s1 += o.items[c[0]] * a.length;
		else {
			a.each(function() {
				s1 += $(this)[c[1]](true)
			})
		}
		if (b && typeof o[c[2]] == 'number')
			s2 += o[c[2]];
		else if (typeof o.items[c[2]] == 'number')
			s2 += o.items[c[2]];
		else {
			a.each(function() {
				var m = $(this)[c[3]](true);
				if (s2 < m)
					s2 = m
			})
		}
		return [ s1, s2 ]
	}
	;
	function mapWrapperSizes(a, o) {
		var b = (o.usePadding) ? o.padding : [ 0, 0, 0, 0 ];
		var c = {};
		c[o.dimentions[0]] = a[0] + b[1] + b[3];
		c[o.dimentions[2]] = a[1] + b[0] + b[2];
		return c
	}
	;
	function setSizes(a, o) {
		var b = a.parent(), $i = getItems(a), $l = $i.filter(':nth('
				+ (o.items.visible - 1) + ')'), is = getSizes(o, $i, false);
		b.css(mapWrapperSizes(getSizes(o, $i.filter(':lt(' + o.items.visible
				+ ')'), true), o));
		if (o.usePadding) {
			$l
					.css(o.dimentions[6], $l.data('cfs_origCssMargin')
							+ o.padding[1]);
			a.css(o.dimentions[5], o.padding[0]);
			a.css(o.dimentions[4], o.padding[3])
		}
		a.css(o.dimentions[0], is[0] * 2);
		a.css(o.dimentions[2], is[1])
	}
	;
	function getPadding(p) {
		if (typeof p == 'number')
			p = [ p ];
		else if (typeof p == 'string')
			p = p.split('px').join('').split(' ');
		if (typeof p != 'object') {
			log('Not a valid value, padding set to "0".');
			p = [ 0 ]
		}
		for (i in p) {
			p[i] = parseInt(p[i])
		}
		switch (p.length) {
		case 0:
			return [ 0, 0, 0, 0 ];
		case 1:
			return [ p[0], p[0], p[0], p[0] ];
		case 2:
			return [ p[0], p[1], p[0], p[1] ];
		case 3:
			return [ p[0], p[1], p[2], p[1] ];
		default:
			return p
		}
	}
	;
	function log(m) {
		if (typeof m == 'string')
			m = 'carouFredSel: ' + m;
		if (window.console && window.console.log)
			window.console.log(m);
		else
			try {
				console.log(m)
			} catch (err) {
			}
		return false
	}
	;
	$.fn.caroufredsel = function(o) {
		this.carouFredSel(o)
	}
})(jQuery);