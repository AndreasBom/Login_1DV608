<?php

class DateTimeView {


	public function show() {

		$dateNow = getdate();

		$timeString = "<p>{$dateNow['weekday']}, the {$dateNow['mday']}:th of {$dateNow['month']}{$dateNow['year']}, The time is " . date('H:i:s') . "</p>";

		return $timeString;
	}
}