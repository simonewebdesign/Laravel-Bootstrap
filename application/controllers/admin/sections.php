<?php
class Admin_Sections_Controller extends Admin_Controller
{

    public $restful = true;
    public $views = 'sections';

    public function get_index()
    {
    	$this->data['sections'] = Cmssection::order_by('title','asc')->get();
        return View::make('admin.'.$this->views.'.index',$this->data);
    }

    public function get_edit($object_id = false){
    	// Do our checks to make sure things are in place
    	if(!$object_id) return Redirect::to('admin/'.$this->views);
    	$object = Cmssection::find($object_id);
    	if(!$object) return Redirect::to('admin/'.$this->views);
    	$this->data['section'] = $object;
        $this->data['pages'] = Page::all();
    	return View::make('admin.'.$this->views.'.form',$this->data);
    }

    /**
     * Deletes our CMS section on POST, checks to see if ID exists first
     * @return redirect
     */
    public function post_delete(){

        $rules = array(
            'id'  => 'required|exists:sections',
        );
        $validation = Validator::make(Input::all(), $rules);
        if ($validation->fails())
        {
            Messages::add('error','You tried to delete a section that doesn\'t exist.');
            return Redirect::to('admin/'.$this->views.'');
        }else{
            Uploadr::remove('section',Input::get('id'));
            $section = Cmssection::find(Input::get('id'));
            $section->delete();
            Messages::add('success','Section Removed');
            return Redirect::to('admin/'.$this->views.'');
        }
    }

    /**
     * Creates our section when POSTed to. Performs snazzy validation.
     * @return [type] [description]
     */
    public function post_create(){
        $rules = array(
            'title'  => 'required|max:255',
            'content'  => 'required',
            'page_id'  => 'integer|exists:pages,id',
            'image' => 'image|max:2500',
        );
        $validation = Validator::make(Input::all(), $rules);
        if ($validation->fails())
        {
            Messages::add('error',$validation->errors->all());
            return Redirect::to('admin/'.$this->views.'/create')->with_input();
        }else{
            $section = new Cmssection;
            $section->title = Input::get('title');
            $section->content = Input::get('content');
            $section->created_by = $this->data['user']->id;
            $section->page_id = Input::get('page_id');
            $section->save();

            $upload_details = array(
                'upload_field_name'=>'image',
                'upload_type'=>'section',
                'upload_link_id'=>$section->id,
                'remove_existing_for_link'=>true,
                'title'=>$section->title,
                'path_to_store'=>path('public').'uploads/',
                'resizing'=>array(
                    'small'=>array('w'=>200,'h'=>200),
                    'thumb'=>array('w'=>150,'h'=>150)
                )
            );
            $upload = Uploadr::upload($upload_details);

            Messages::add('success','Section Added');
            return Redirect::to('admin/'.$this->views.'');
        }
    }

    public function post_edit(){
        $rules = array(
            'id'  => 'required|exists:sections',
            'title'  => 'required|max:255',
            'content' => 'required',
            'page_id'  => 'integer|exists:pages,id',
            'image' => 'image|max:2500'
        );
        $validation = Validator::make(Input::all(), $rules);
        if ($validation->fails())
        {
            Messages::add('error',$validation->errors->all());
            return Redirect::to('admin/'.$this->views.'/edit')->with_input();
        }else{
            $section = Cmssection::find(Input::get('id'));
            $section->title = Input::get('title');
            $section->content = Input::get('content');
            $section->page_id = Input::get('page_id');
            $section->save();

            $upload_details = array(
                'upload_field_name'=>'image',
                'upload_type'=>'section',
                'upload_link_id'=>$section->id,
                'remove_existing_for_link'=>false,
                'title'=>$section->title,
                'path_to_store'=>path('public').'uploads/',
                'resizing'=>array(
                    'small'=>array('w'=>200,'h'=>200),
                    'thumb'=>array('w'=>150,'h'=>150)
                )
            );
            $upload = Uploadr::upload($upload_details);

            Messages::add('success','Section Saved');
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
            $object = Cmssection::find($object_id);
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

    public function get_create(){
        $this->data['create'] = true;
        $this->data['pages'] = Page::all();
        return View::make('admin.'.$this->views.'.form',$this->data);
    }

}