<?php

namespace view;
class DateTimeView {


	public function show() {
		//{$dateNow['mday']}:th
		$dateNow = getdate();
		$suffix =date("S");
		$timeString = "<p>{$dateNow['weekday']}, the {$dateNow['mday']}$suffix of {$dateNow['month']} {$dateNow['year']}, The time is " . date('H:i:s') . "</p>";

		return $timeString;
	}
}