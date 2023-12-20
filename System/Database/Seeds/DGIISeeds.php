<?php
namespace DGII\Database\Seeds;

use DGII\Model\Term;
use Illuminate\Database\Seeder;

class DGIISeeds extends Seeder 
{    
    public function run(): void
    {
        ## LIBRARIES
        (new \DGII\User\Driver)->install(new Term);
    }
}