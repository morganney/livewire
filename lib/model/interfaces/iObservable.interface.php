<?php
	interface iObservable {
		public function attachObserver(iObserver $observer);
		public function notifyObserver($type = 'default');
	}
	