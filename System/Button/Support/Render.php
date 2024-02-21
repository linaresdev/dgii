<?php
namespace DGII\Button\Support;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

class Render
{

    protected $data;

    protected $type = [
        "link"      => "a",
        "submit"    => "button",
    ];

    public function __construct($data=null)
    {
        $this->data = $data;
    }

    public function tab($index=0)
    {
        return str_repeat(" ", $index);
    }
    public function btn()
    {
        return $this->data;
        
        $tag = $this->tab();
        $tag .= '<a>'."\n";

        $tag .= $this->tab(4);
        $tag .= "link\n";

        $tag .= $this->tab();
        $tag .= '<a>'."\n";

        return $tag;
    }
}