<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function objectToArray ($object) {  //TODO should be in a helper class 
	    if(!is_object($object) && !is_array($object))
	        return $object;	
	    return array_map('objectToArray', (array) $object);
	}

?>