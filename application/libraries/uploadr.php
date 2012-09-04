<?php
class Uploadr {

     /**
      * Attempts to upload a file, adds it to the database and removes other database entries for that file type if they are asked to be removed
      * @param  string  $field             The name of the $_FILES field you want to upload
      * @param  boolean $upload_type       The type of upload ('news', 'gallery', 'section') etc
      * @param  boolean $type_id           The ID of the item (above) that the upload is linked to
      * @param  boolean $remove_existing   Setting this to true will remove all existing uploads of the passed in type (useful for replacing news article images when a new on
      * @param  boolean $title             Sets the title of the upload
      * @param  boolean $path_to_store     Sets the path to the upload (where it should go)
      * @return object                     Returns the upload object so we can work with the uploaded file and details
      */
     public static function upload($details = array()){

          $upload_details = array(
                //'upload_field_name'=>'image',
                //'upload_type'=>'campaign',
                //'upload_link_id'=>$campaign->id,
                'remove_existing_for_link'=>true,
                //'title'=>$campaign->name,
                'path_to_store'=>path('public').'uploads/',
                'resizing'=>array(
                    'small'=>array('w'=>200,'h'=>200),
                    'thumb'=>array('w'=>200,'h'=>200)
                )
            );

          if ( !empty($details) ){
            $required_keys = array('upload_field_name','upload_type','upload_link_id','title');
            $continue = true;
            foreach($required_keys as $key){
              if( !isset($details[$key]) || empty($details[$key]) ){
                Messages::add('error','Your upload array details are not complete... please fill this in properly.');
                $continue = false;
              }
            }

            if($continue){

              $configuration = $details + $upload_details;
              $input = Input::file($configuration['upload_field_name']);
              if( $input && $input['error'] == UPLOAD_ERR_OK ){
                if($configuration['remove_existing_for_link']) static::remove($configuration['upload_type'],$configuration['upload_link_id']);
                $ext = File::extension($input['name']);
                $filename = Str::slug($configuration['upload_type'].'-'.$configuration['upload_link_id'].'-'.Str::limit(md5($input['name']),10,false).'-'.$configuration['title'], '-');
                Input::upload($configuration['upload_field_name'], $configuration['path_to_store'], $filename.'.'.$ext);
                $upload = new Upload;
                $upload->link_type = $configuration['upload_type'];
                $upload->link_id = $configuration['upload_link_id'];
                $upload->filename = $filename.'.'.$ext;
                if(Koki::is_image($configuration['path_to_store'].$filename.'.'.$ext)){
                  $upload->small_filename = $filename.'_small'.'.'.$ext;
                  $upload->thumb_filename = $filename.'_thumb'.'.'.$ext;
                  $upload->image = 1;
                }
                $upload->extension = $ext;
                $upload->user_id = Auth::user()->id;
                $upload->save();
                if(Koki::is_image($configuration['path_to_store'].$filename.'.'.$ext)){
                  WideImage::load($configuration['path_to_store'].$upload->filename)->resize($configuration['resizing']['small']['w'], $configuration['resizing']['small']['h'])->saveToFile($configuration['path_to_store'].$upload->small_filename);
                  WideImage::load($configuration['path_to_store'].$upload->small_filename)->crop('center', 'center', $configuration['resizing']['thumb']['w'], $configuration['resizing']['thumb']['h'])->saveToFile($configuration['path_to_store'].$upload->thumb_filename);
                }
                return true;  
              }
            }
          }else{
            Messages::add('error','Your upload array details are empty... please fill this in properly.');
          }
          return false;
     }

     /**
      * Removes all uploads based on upload type and the type_id.
      * @param  boolean $upload_type The type of upload ('news', 'gallery', 'section') etc
      * @param  boolean $type_id     The ID of the item (above) that the upload is linked to
      * @param  string  $path_to_store     There might be a different physical path that the upload is at (not sure why, enter that here)
      * @return int                  Notification of whether or not the upload object was deleted
      */
     public static function remove($upload_type = false, $type_id = false,$path_to_store = false){
          if(!$upload_type || !$type_id) return false;
          if(!$path_to_store) $path_to_store = path('public').'uploads/';
          $uploads = Upload::where('link_type','=',$upload_type)->where('link_id','=',$type_id)->get();
          if($uploads){
               foreach($uploads as $upload){
                    if($upload->filename && file_exists($path_to_store.$upload->filename)) @unlink($path_to_store.$upload->filename);
                    if($upload->small_filename && file_exists($path_to_store.$upload->small_filename)) @unlink($path_to_store.$upload->small_filename);
                    if($upload->thumb_filename && file_exists($path_to_store.$upload->thumb_filename)) @unlink($path_to_store.$upload->thumb_filename);
               }
          }
          return Upload::where('link_type','=',$upload_type)->where('link_id','=',$type_id)->delete();
     }

      public static function remove_singular($upload_id = false, $path_to_store = false){
          if(!$upload_id) return false;
          if(!$path_to_store) $path_to_store = path('public').'uploads/';
          $uploads = Upload::where('id','=',$upload_id)->get();
          if($uploads){
               foreach($uploads as $upload){
                    if($upload->filename && file_exists($path_to_store.$upload->filename)) @unlink($path_to_store.$upload->filename);
                    if($upload->small_filename && file_exists($path_to_store.$upload->small_filename)) @unlink($path_to_store.$upload->small_filename);
                    if($upload->thumb_filename && file_exists($path_to_store.$upload->thumb_filename)) @unlink($path_to_store.$upload->thumb_filename);
               }
          }
          return Upload::where('id','=',$upload_id)->delete();
     }

}