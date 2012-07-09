<?php
class Page extends Eloquent {

	public static $timestamps = true;
	public function section()
	{
		return $this->has_many('Cmssection','page_id');
	}
	public function user()
	{
		return $this->belongs_to('User');
	}
}