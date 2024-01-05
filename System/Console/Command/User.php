<?php
namespace DGII\Console\Command;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

use DGII\User\Model\Store;
use Illuminate\Console\Command;
use DGII\Console\Command\Account\UpdatePassword;

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
}