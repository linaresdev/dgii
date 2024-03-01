<?php
namespace DGII\Support;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

class Alert
{
    protected $prefix;

    protected $zip;

    protected $taggs = [];

    protected $session;

    protected $METHODS = [
        "info", "warning", "danger", "success"
    ];

    public function __construct($app) {
        $this->session = $app["session.store"];
    }

    public function header($type) {
        $data["type"]       = $type;
        $data["style"]      = "alert-$type";
        $data["title"]      = ucwords($type);
        $data["message"]    = $message;
        $data["created_at"] = now();
    }

    public function flash($type, $message=[])
    {
        $this->zip          = $this->prefix.'.'.\Str::random(9);
        $data["type"]       = $type;
        $data["style"]      = "alert-$type";
        $data["title"]      = ucwords($type);
        $data["message"]    = $message;
        $data["created_at"] = now();

        $this->tagged[$this->zip] = $data;

        $this->session->flash($this->zip, $data);
    }

    public function prefix( $slug=null ) {
        $this->prefix = $slug; return $this;
    }

    public function form( $slug=null, $tpl="dgii::alerts.form" ) {

        $view=null;

        ## Alert
        if( $this->session->has($slug) )
        {
            if( !empty( ($sess = $this->session->get($slug)) ) )
            {                
                $view .= view($tpl, ["data" => $sess]);
            }
        }

        #Form Alert
        if( $this->session->has("errors") ) {            
            $view .= view("dgii::alerts.form");
        }

        return $view;
    }

    public function listen( $prefix, $view="dgii::alerts.news" )
    {
        if( $this->session->has($prefix) ) {
            if( !empty(($data = $this->session->get($prefix))) )
            {
                return view($view, ["data" => $data]);
            }
        }
    }

    public function addErrors($type, $message)
    {
        $validate   = validator([],[]);        
        $errors     = $validate->errors();

        if( is_array($message) )
        {
            $this->session->flash( "type", $type );

            foreach( $message as $key => $ms )
            {
                $errors->add($key, $ms);
            }
        }
        else
        {
            $this->session->flash( "type", $type );
            $errors->add("line", $message);
        }

        return $validate;
    }

    public function __call($method, $message)
    {        
        if( in_array($method, $this->METHODS) )
        {
            $this->flash($method, $message);
        }
    }
}