<?php
namespace DGII\Support;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

class Alert {

    protected $prefix;

    protected $taggs = [];

    protected $session;

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

    public function flash($type, $message=[]) {
        $this->zip          = $this->prefix.'.'.\Str::random(9);
        $data["type"]       = $type;
        $data["style"]      = "alert-$type";
        $data["title"]      = ucwords($type);
        $data["message"]    = $message;
        $data["created_at"] = now();

        $this->session->flash($this->zip, $data);
    }

    public function prefix( $slug=null ) {
        $this->prefix = $slug; return $this;
    }

    public function form( $slug=null, $tpl="alert::simple" ) {

        $view=null;

        ## Alert
        if( $this->session->has($slug) ) {
            if( !empty( ($sess = $this->session->get($slug)) ) ) {
                $view .= view($tpl, ["data" => $sess]);
            }
        }

        #Form Alert
        if( $this->session->has("errors") ) {

        }

        return $view;
    }

    public function danger($message) {
        $this->fire("danger", $message);
    }

    public function info($message) {
        $this->fire("info", $message);
    }
}