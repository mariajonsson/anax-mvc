<?php

namespace Anax\HTMLForm;

/**
 * Form to add comment
 *
 */
class CFormContentAdd extends \Mos\HTMLForm\CForm
{
    use \Anax\DI\TInjectionaware,
        \Anax\MVC\TRedirectHelpers;

    

    /**
     * Constructor
     *
     */
    public function __construct()
    {
        parent::__construct([], [
        
	    'title' => [
                'type'        => 'text',
                'label'       => 'Rubrik',
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            
            'url' => [
                'type'        => 'text',
                'label'       => 'URL',
                'required'    => true,
                //'validation'  => ['not_empty'],
            ],
            
            'slug' => [
                'type'        => 'text',
                'label'       => 'Slug',
                'required'    => true,
                //'validation'  => ['not_empty'],
            ],
        	
            'data' => [
                'type'        => 'textarea',
                'label'       => 'Innehåll',
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            
            'acronym' => [
                'type'        => 'text',
                'label'       => 'Namn',
                'required'    => true,
                'validation'  => ['not_empty'],
            ],
            
            'filter' => [
                'type'        => 'text',
                'label'       => 'Filter',
                //'required'    => true,
                'description'     => 'Ex: markdown, nl2br',
            ],
            
            'type' => [
                'type'        => 'select',
                'label'       => 'Typ',
                'required'    => true,
                'options'     => ['blog' => 'blog','page' => 'page'],
            ],
            
            'published' => [
                'type'        => 'checkbox',
                'label'       => 'Publicera',
                'checked'     => false,
            ],
            
            'submit' => [
                'type'      => 'submit',
                'callback'  => [$this, 'callbackSubmit'],
                'value'     => 'Spara',
            ],
            'reset' => [
                'type'      => 'reset',
                //'callback'  => [$this, 'callbackReset'],
                'value'     => 'Återställ',
            ],
            
        ]);
        

        
    }



    /**
     * Customise the check() method.
     *
     * @param callable $callIfSuccess handler to call if function returns true.
     * @param callable $callIfFail    handler to call if function returns true.
     */
    public function check($callIfSuccess = null, $callIfFail = null)
    {
        return parent::check([$this, 'callbackSuccess'], [$this, 'callbackFail']);
    }



    /**
     * Callback for submit-button.
     *
     */
    public function callbackSubmit()
    {
    	
        $now = date('Y-m-d H:i:s');
        $published = !empty($_POST['published'])?$now:null;
        
	$content = new \Meax\Content\Content();
        $content->setDI($this->di);
        $saved = $content->save(array('title' => $this->Value('title'), 'url' => $this->Value('url'), 'slug' => $this->Value('slug'), 'acronym' => $this->Value('acronym'), 'created' => $now, 'data' => $this->Value('data'), 'filter' => $this->Value('filter'), 'type' => $this->Value('type'), 'published' => $published));
    
       // $this->saveInSession = true;
        
        if($saved) 
        {
        return true;
        }
        else return false;
    }

     /**
     * Callback reset
     *
     */
    public function callbackReset()
    {
        //$this->redirectTo($this->redirect);
    }


    /**
     * Callback for submit-button.
     *
     */
    public function callbackSubmitFail()
    {
        $this->AddOutput("<p><i>DoSubmitFail(): Form was submitted but I failed to process/save/validate it</i></p>");
        return false;
    }



    /**
     * Callback What to do if the form was submitted?
     *
     */
    public function callbackSuccess()
    {
        $this->redirectTo('content');
    }


    /**
     * Callback What to do when form could not be processed?
     *
     */
    public function callbackFail()
    {
        $this->AddOutput("<p><i>Form was submitted and the Check() method returned false.</i></p>");
        //$this->redirectTo('comments/edit');
    }
}
