<?php
/*
	CartoDB Proxy Private Class
	This class should not be modified and all overrides should be modified in the public functions.
*/
class CartoProxy extends _CartoProxy {

	public function authenticate() {
		// Write your authentication code here to determine if the request should be made.
		return true;
	}

}
?>