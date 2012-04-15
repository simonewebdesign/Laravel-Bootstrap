<?php
class Page_Controller extends Base_Controller
{

    public $restful = true;

    /**
     * This method checks to see if a view exists and if it does loads it along with any
     * associated data from the database. It then checks to see if a function exists for
     * the passed in page name (substituting dashes for underscores and runs that) if it exists.
     * @param  string  $page            The page name
     * @param  string  $variable        Allows us to pass a second variable to things
     * @return view                     Ideally a view of some kind
     */
    public function get_index($page = 'home',$variable=false)
    {        
        $this->data['page'] = Page::where('slug','=',$page)->first();
        $function = strtolower(Request::method().'_'.str_replace('-','_',$page));
        if(method_exists($this, $function)){
            $this->$function($variable);
        } else {
            if(View::exists('site.'.$page)){
                return View::make('site.'.$page,$this->data);
            }else{
                return Response::error('404');
            }            
        }  
    }
    public function post_index($page = 'home',$variable=false){
        $this->get_index($page,$variable);
    }

    /**
     * This would be run if we went to www.domain.com/example
     * Because we use a restful controller we can just use post_example functions
     * to deal with any post requests we want to handle too. Magical.
     * @return string
     */
    public function get_example(){
        echo '<h1>This is an example</h1>';
        echo Form::open('/example');
        echo Form::token();
        echo '<p>'.Form::label('your_name','Your Name').Form::text('your_name',Input::old('your_name')).'</p>';
        echo '<p>'.Form::label('email','Your Email').Form::text('email',Input::old('email')).'</p>';
        echo '<p>'.Form::label('number','Your Number').Form::text('number',Input::old('number')).'</p>';
        echo '<p>'.Form::label('enquiry','Your Message').Form::textarea('enquiry',Input::old('enquiry')).'</p>';
        echo '<p>'.Form::submit('Send Message').'</p>';
        echo Form::close();
    }
    public function post_example(){
        echo 'YOU POSTED, CONGRATS';
    }

}