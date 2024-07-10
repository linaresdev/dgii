<?php

if( !function_exists("stack") ) {
	function stack($type=null, $header=null, $messages=[] ) {
		return (new \DGII\User\Model\UserStack)->add(
			$type, $header, $messages
		);
	}
}