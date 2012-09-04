<?php
class Admin_News_Controller extends Admin_Controller
{

    public $restful = true;
    public $views = 'news';

    public function get_index()
    {
    	$this->data['news'] = News::order_by('created_at','desc')->get();
        return View::make('admin.'.$this->views.'.index',$this->data);
    }

    public function get_edit($news_id = false){
    	// Do our checks to make sure things are in place
    	if(!$news_id) return Redirect::to('admin/'.$this->views);
    	$article = News::find($news_id);
    	if(!$article) return Redirect::to('admin/'.$this->views);
    	$this->data['article'] = $article;
    	return View::make('admin.'.$this->views.'.form',$this->data);
    }

    public function post_delete(){
        $rules = array(
            'id'  => 'required|exists:news',
        );
        $validation = Validator::make(Input::all(), $rules);
        if ($validation->fails())
        {
            Messages::add('error','You tried to delete a post that doesn\'t exist.');
            return Redirect::to('admin/'.$this->views.'');
        }else{
            Uploadr::remove('news',Input::get('id'));
            $article = News::find(Input::get('id'));
            $article->delete();
            Messages::add('success','Article Removed');
            return Redirect::to('admin/'.$this->views.'');
        }
    }

    public function post_create(){
        $rules = array(
            'title'  => 'required|unique:news|max:255',
            'content' => 'required',
            'image' => 'image|max:2500'
        );
        $validation = Validator::make(Input::all(), $rules);
        if ($validation->fails())
        {
            Messages::add('error',$validation->errors->all());
            return Redirect::to('admin/'.$this->views.'/create')->with_input();
        }else{
            $article = new News;
            $article->title = Input::get('title');
            $article->url_title = Str::slug(Input::get('title'), '-');
            $article->content = Input::get('content');
            $article->created_by = $this->data['user']->id;
            $article->save();

            $upload_details = array(
                'upload_field_name'=>'image',
                'upload_type'=>'news',
                'upload_link_id'=>$article->id,
                'remove_existing_for_link'=>true,
                'title'=>$article->title,
                'path_to_store'=>path('public').'uploads/',
                'resizing'=>array(
                    'small'=>array('w'=>200,'h'=>200),
                    'thumb'=>array('w'=>150,'h'=>150)
                )
            );
            $upload = Uploadr::upload($upload_details);

            Messages::add('success','News article added');
            return Redirect::to('admin/'.$this->views.'');
        }
    }

    public function post_edit(){
        $rules = array(
            'id'  => 'required|exists:news',
            'title'  => 'required|max:255',
            'content' => 'required',
            'image' => 'image|max:2500'
        );
        $validation = Validator::make(Input::all(), $rules);
        if ($validation->fails())
        {
            Messages::add('error',$validation->errors->all());
            return Redirect::to('admin/'.$this->views.'/edit/'.Input::get('id'))->with_input();
        }else{
            $article = News::find(Input::get('id'));
            $article->title = Input::get('title');
            $article->url_title = Str::slug(Input::get('title'), '-');
            $article->content = Input::get('content');
            $article->save();

            $upload_details = array(
                'upload_field_name'=>'image',
                'upload_type'=>'news',
                'upload_link_id'=>$article->id,
                'remove_existing_for_link'=>false,
                'title'=>$article->title,
                'path_to_store'=>path('public').'uploads/',
                'resizing'=>array(
                    'small'=>array('w'=>200,'h'=>200),
                    'thumb'=>array('w'=>150,'h'=>150)
                )
            );
            $upload = Uploadr::upload($upload_details);

            Messages::add('success','News article saved');
            return Redirect::to('admin/'.$this->views.'/edit/'.Input::get('id'));
        }
    }

/**
     * Update the order of the returned image IDs
     * @return boolean
     */
    public function post_update_images_order(){
        $decoded = json_decode(Input::get('data'));
        if($decoded){
            foreach($decoded as $order=>$id){
                if($img = Upload::find($id)){
                    $img->order = $order;
                    $img->save();
                }
            }
        }
        return true;
    }

    /**
     * Delete an upload from a section
     * @return [type] [description]
     */
    public function post_delete_upload(){
        $in = explode('-',Input::get('id'));
        if($in && count($in) == 2){
            $object_id = $in[0];
            $object_upload_id = $in[1];
            $object = News::find($object_id);
            if($object){
                $upload = $object->uploads()->where('id','=',$object_upload_id);
                if($upload){
                    Uploadr::remove_singular($object_upload_id);
                    return Redirect::to('admin/'.$this->views.'/edit/'.$object_id);
                }
            }
        }
        return Redirect::to('admin/'.$this->views);
    }


    /**
     * Our news article create function
     *
     **/
    public function get_create(){
        $this->data['create'] = true;
        return View::make('admin.'.$this->views.'.form',$this->data);
    }

}