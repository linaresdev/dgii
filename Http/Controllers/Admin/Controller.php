<?php
namespace DGII\Http\Controllers\Admin;

/*
  *---------------------------------------------------------
  * ©Delta
  * Santo Domingo República Dominicana.
  *---------------------------------------------------------
*/

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController {

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $app;

    protected $path = "dgii::admin.";

    public function boot( $app=null, $data=[] ) {
        
        $this->app = $app;

        ## VAR LAYOUT
        $data["icon"] = '<span class="mdi mdi-text"></span>';
        $data["title"] = 'Title Page';

        $this->share($data);

        ## SET LAYOUT
        if( method_exists($this, "setLayout") ) {
            view()->share($this->setLayout());
        }
    }
    public function setLayout() {
        return [
            "container" => "container"
        ];
    }

    public function share($data) {
        if(!empty($data) && is_array($data) ) {
            view()->share($data);
        }
    }

    public function render($view=NULL, $data=[], $mergeData=[]) {

        if(view()->exists(($path = $this->path.$view))) {
            return view($path, $data, $mergeData);
        }

        abort(500, "La vista {$path} no existe");
    }

}