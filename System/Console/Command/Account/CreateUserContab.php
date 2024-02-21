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
use function Laravel\Prompts\text;
use function Laravel\Prompts\select;
use function Laravel\Prompts\multiselect;

class CreateUserContab
{
    public function render($app, $entity )
    {
        $app->info(" ".$entity->name);
        $app->info(" FORMULARIO DE USUARIOS");
        $app->info(str_repeat("==", 34));

        $data = $this->form(); 
        
        while(($errors = $this->errors($data))->any())
        {
            foreach( $errors->all() as $message ){
                $app->error($message);
            }

            $data = $this->form();
        }

        

        if( ($user = (new Store)->create($data)) )
        {
            $user->syncGroup( $entity->group->id, [
                "view"      => 1, 
                "insert"    => 1, 
                "update"    => 1, 
                "delete"    => 1,
            ]);

           return $app->info("Cuenta creada correctamente"); 
        }

        $this->error("Ocurrió un error al tratar de crear la cuenta");       
    }

    public function errors( $data )
    {
        $ruls["firstname"]  = "required";
        $ruls["lastname"]   = "required";
        $ruls["email"]      = "required|unique:\DGII\User\Model\Store,email";
        $ruls["password"]   = "required";

        return validator( $data, $ruls )->errors();
    }

    public function form()
    {
        $data['type']       = 'local';

        $data["firstname"] = text(
            label: "Nombre",
            placeholder: "Escriba el nombre",
            default: '',
            hint: "Nombre para la nueva cuenta"
        );

        $data["lastname"] = text(
            label: "Apellidos",
            placeholder: "Apellidos",
            hint: " Apillidos para la nueva cuenta"
        );

        $data["email"] = text(
            label: "Correo electrónico",
            placeholder: "Escriba el correo electrónico",
            default: '',
            hint: 'Cuenta de correo para el nuevo usuario'
        );

        $data["password"] = password(
            label: __("new.password"),
            placeholder: __("new.password"),
            hint: 'Defina la clave de acceso para esta cuenta'
        );

        $data["confirm"] = password(
            label: __("confirm.password"),
            placeholder: __("confirm.password"),
            hint: 'Confirmar la nueva clave de acceso'
        ); 

        $data["name"] = $data["firstname"];

        $data["activated"] = 1;
        
        return $data;
    }
}