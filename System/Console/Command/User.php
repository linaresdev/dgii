<?php
namespace DGII\Console\Command;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

use DGII\Model\Hacienda;
use DGII\User\Model\Store;
use Illuminate\Console\Command;
use DGII\Console\Command\Account\UpdatePassword;
use DGII\Console\Command\Account\CreateUserContab;

use function Laravel\Prompts\text;
use function Laravel\Prompts\select;
use function Laravel\Prompts\multiselect;

class User extends Command
{
    protected $signature    = 'dgii:account 
                                {opt}
                                {email?}';

    protected $description  = 'Dgii Users Account';

    public function handle()
    {
        if( method_exists( $this, ($opt = $this->argument("opt")) ) )
        {
            $this->{$opt}();
        }        
    }    

    public function update()
    {
        $email = text(
            label: __("words.email"),
            placeholder: __("update.from.email"),
            default: '',
            hint: 'Mantenimiento de la cuenta'
        );

        $user = (new Store)->where("email", $email)->first() ?? null;        
        
        if( $user != null ) {

            $role = select(
                label: strtoupper($user->fullname),
                options: [
                    'updateCredential'  => 'Actualizar Credenciales',
                    'updatePasswor'     => 'Actualizar contraseña'
                ]
            );
        }        

        (new UpdatePassword)->render($this, $user);        
    }

    public function contab()
    {
        $rnc = text(
            label: __("words.rnc"),
            placeholder: __("words.entity"),
            default: '',
            hint: 'RNC de la entida que pertenecera el usuario'
        );

        while( (($entity = (new Hacienda)->getEntity($rnc)) == null) )
        {
            $this->error("No existe la entidad");

            $rnc = text(
                label: __("words.rnc"),
                placeholder: __("words.entity"),
                default: $rnc,
                hint: 'RNC de la entida que pertenecera el usuario'
            );
        }

        return (new CreateUserContab)->render($this, $entity);    
    }
}