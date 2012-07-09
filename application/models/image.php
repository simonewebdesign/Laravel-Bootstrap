<?php
class Image extends Eloquent {

	public static $timestamps = true;
	public static $table = 'gallery_images';

	public function gallery()
	{
		return $this->belongs_to('Gallery');
	}
	public function user()
	{
		return $this->belongs_to('User');
	}
	public function uploads()
	{
		return $this->has_many('Upload', 'link_id')->where('link_type', '=', 'image');
	}
}