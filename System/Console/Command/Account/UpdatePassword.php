<?php
namespace DGII\Console\Command\Account;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

use DGII\User\Model\Store;
use Illuminate\Support\Facades\Validator;

use function Laravel\Prompts\info;
use function Laravel\Prompts\password;

class UpdatePassword
{
    public function render($app, $user )
    {
        $app->info(" FORMULARIO");
        $app->info(" Actualizar contraseña de acceso");
        $app->info(str_repeat("==", 34));

        $data = $this->form(); 
        
        while(($errors = $this->errors($data))->any())
        {
            foreach( $errors->all() as $message ){
                $app->error($message);
            }

            $data = $this->form();
        }

        if( $user->update($data) ) {
            return info("Contraseña actualizada correctamente");
        }
        else {
            $app->error("Error al tratar de actuaizar la contraseña de la cuenta");
        }        
    }

    public function errors( $data )
    {
        $ruls["password"]   = "required";
        $ruls["confirm"]    = "required|same:password";

        return Validator::make($data, $ruls)->errors();
    }

    public function form()
    {
        $data["password"] = password(
            label: __("new.password"),
            placeholder: __("new.password"),
        );

        $data["confirm"] = password(
            label: __("confirm.password"),
            placeholder: __("confirm.password"),
        ); 
        
        return $data;
    }
}