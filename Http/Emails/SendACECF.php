<?php
namespace DGII\Http\Emails;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendACECF extends Mailable
{
    use Queueable, SerializesModels;

    public $entity;

    public $ecf;

    public $acecf;

    public $subject;

    public $messages = [];
    
    public function __construct( $entity, $ecf, $acecf )
    {
        $this->entity   = $entity;
        $this->ecf      = $ecf;
        $this->acecf    = $acecf;

        $this->subject  =  "Detalle Aprobación Comercial";

        if( !empty(($fileData = $acecf->acecf)) )
        {
            $this->messages = $fileData->arrayFormat();
        }
    }

    public function build()
    {
        return $this->view("dgii::entities.entity.mails.acecf")->attach($this->acecf->pathAcecf());
    }
}