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

class Dgii extends Command
{
    protected $signature    = 'dgii {opt}';

    protected $description  = 'Dgii Commands Applications';

    protected $actions      = "stop|start|install|uninstall";

    public function handle()
    {
        if( method_exists( $this, ($opt = $this->argument("opt")) ) )
        {
            return $this->{$opt}();
        }  
        
        $this->error(__("command.unknown"));
        $this->error("Acciones disponibles: ".$this->actions);
    }

    public function stop() {
    }

    public function reset() {
        \Artisan::call("migrate:reset");
    }

    public function start() {
    }

    public function install() {
        return (new \DGII\Console\Command\Support\Install)->make($this);
    }

    public function uninstall() {
       // return (new \DGII\Console\Command\Support\Uninstall)->make($this);
    }
    
}