<?php
class Gallery extends Eloquent {

	public static $timestamps = true;
	public static $table = 'gallery';

	public function image()
	{
		return $this->has_many('Image','gallery_id')->order_by('order','asc');
	}
	public function user()
	{
		return $this->belongs_to('User');
	}
}