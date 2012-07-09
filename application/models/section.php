<?php
class Cmsection extends Eloquent {

	public static $timestamps = true;
	public function page()
	{
		return $this->belongs_to('Page');
	}
	public function user()
	{
		return $this->belongs_to('User');
	}
}