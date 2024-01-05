<?php
namespace DGII\Console;

/*
*---------------------------------------------------------
* ©Delta
*---------------------------------------------------------
*/

return ( new class
{

    public function commands() {
        return [
            \DGII\Console\Command\Dgii::class,
            \DGII\Console\Command\User::class
        ];
    }
});