<?php 
namespace App\Utilities;
use \Zend\Permissions\Acl\Acl as ZendAcl;

class Acl extends ZendAcl
{
    public function __construct($aclArray = [])
    {
        // APPLICATION ROLES
        foreach ($aclArray['roles'] as $key => $value) {
            if(is_array($value)) {
                $this->addRole($value[0], $value[1]);
                continue;
            }
            $this->addRole($value);
        }

        foreach ($aclArray['permissions'] as $key => $value) {
            // APPLICATION RESOURCES
            // Application resources == Slim route patterns
            $this->addResource($value['route']);
            // APPLICATION PERMISSIONS
            // Now we allow or deny a role's access to resources. The third argument
            // is 'privilege'. We're using HTTP method as 'privilege'.
            $this->allow($value['role'], $value['route'], $value['methods']);
        }
        
        // This allows admin access to everything
        $this->allow('admin');
    }
}