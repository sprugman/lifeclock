	"use strict";

	var showDays, yearCount, today = Date.today(), $life;

	var drawDay = function(d, $m) {
		var $d = $('<div class="day"></div>');
		if (d < Date.today()) {
			$d.addClass('past');
			// var r = Math.random()*100;
			// if (r < 10) $d.addClass('sad');
			// else if (r < 20) $d.addClass('happy');
		}
		$m.append($d);
	};

	var drawMonth = function(d, $y) {
		var $m = $('<div class="month"></div>').attr('title', d.toString('MMM yyyy'));
		if (d < today) {
			$m.addClass('pastMonth');
		}
		if (showDays) {
			var len = d.getDate();
			for (var i = 1; i<len; i++) {
				$m.append('<div class="pad"></div>');
			}
			len = d.getDay();
			for (var i = 1; i<=len; i++) {
				$m.append('<div class="pad"></div>');
			}
		}
		$y.append($m);
		return $m;
	};

	var drawYear = function(d) {
		yearCount++;
		var $y = $('<div class="year"></div>');
		if (yearCount % 10 === 0) {
			$y.addClass('decade');
		}
		var len = d.getMonth();
		for (var i = 1; i<=len; i++) {
			$y.append('<div class="monthPad"></div>');
		}
		$('#life').append($y);
		return $y;
	};

	var millisToDays = function(millis) {
		return millis / 1000 / 60 / 60 / 24;
	}

	var drawLife = function() {
		$life.html('');
		// setTimeout(function(){

			showDays = $('#showDays').is(':checked');
			yearCount = 0;

			var birthdate = $('#birthdate').val(),
				lifeYears = parseInt($('#expectancy').val(), 10),
				d = new Date(birthdate),
				m, $m,
				y, $y,
				end = d.clone().addYears(lifeYears),
				daysSpent = millisToDays(today - d),
				daysLeft = millisToDays(end - today),
				totalDays = millisToDays(end - d);

			while (d < end) {
				if (d.getYear() !== y) {
					y = d.getYear();
					$y = drawYear(d);
				}
				if (d.getMonth() !== m) {
					m = d.getMonth();
					if ($m) {
						$m.append('<div style="clear:both"></div>');
					}
					$m = drawMonth(d, $y);
				}
				if (showDays) {
					drawDay(d, $m);
					$life.removeClass('month-mode');
					d.addDays(1);
				} else {
					$life.addClass('month-mode');
					d.addMonths(1);
				}

			}

			// $life.append('<span class="note">Days Spent: ' + Math.round(daysSpent) + ' (' + Math.round(daysSpent/totalDays*100) + '%)<br>Days Left: ' + Math.round(daysLeft) + '</span>');
			$life.prepend('<span class="note">' + Math.round(totalDays) + ' Days</span>');
			$life.append('<span class="note">' + Math.round(daysSpent/totalDays*100) + '% Gone</span>');

		// }, 0);
		return false;
	};

	var init = function() {
		$life = $('#life');
		$('form').submit(drawLife);
		$('#showDays').change(function(){
			setTimeout(drawLife, 0);
		});
		drawLife();
	};






$(init);