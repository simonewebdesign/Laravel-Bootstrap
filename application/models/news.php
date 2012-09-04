<?php
class News extends Eloquent {
     public static $timestamps = true;
     public function user()
     {
          return $this->belongs_to('User','created_by');
     }
     public function uploads()
     {
          return $this->has_many('Upload', 'link_id')->where('link_type', '=', 'news');
     }
}