<?php

namespace startup\view;

class DateTimeView {


	public function show() {

		$timeString = date('l, \t\h\e d\t\h \o\f F Y, \T\h\e \t\i\m\e \i\s H:i:s');

		return '<p>' . $timeString . '</p>';
	}
}
