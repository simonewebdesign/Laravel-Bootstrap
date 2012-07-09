<?php
class Cmssection extends Eloquent {

	public static $table = 'sections';
	public static $timestamps = true;

	public function page()
	{
		return $this->belongs_to('Page');
	}

	public function uploads()
	{
		return $this->has_many('Upload', 'link_id')->where('link_type', '=', 'section');
	}
}