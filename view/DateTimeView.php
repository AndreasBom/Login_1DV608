<?php

namespace view;

class DateTimeView {

	public function show() {
		$timeString = "<p>" . date('l, \t\h\e jS \o\f F Y\,') . " The time is " . date('H:i:s') . "</p>";

		return $timeString;
	}
}