<?php

class DateTimeView {


	public function show() {

		$dateNow = getdate();

		$timeString = "{$dateNow['weekday']}, the {$dateNow['mday']}:th of {$dateNow['month']}
						{$dateNow['year']}, The time is " . date('H:i:s');

		return $timeString;
	}
}