<?php
namespace DGII\Http\Policy;

/*
*---------------------------------------------------------
* ©IIPEC
*---------------------------------------------------------
*/

use DGII\User\Model\Store;

class EntityGuard
{
    public function getTokenID($data)
    {
        $data = str_replace("Bearer ", null, $data);

        list($tokenID, $token) = explode('|', $data, 2);

        return $tokenID;        
    }

    public function isExpire( $user, $request )
    {        
        if( ($auth = $request->header("authorization")) != null )
        {
            $tokenData = $user->tokens()->find(
                $this->getTokenID($auth)
            );

            if( $tokenData->created_at->diffInMinutes() >= 65 )
            {
                $tokenData->delete();
                return false;
            }  
            
            return true;
        }         
        
        return false;
    }
}