<?php


namespace App\Repositories;


use App\Models\User;

class UserRepository
{

    protected $collection;

    public function __construct()
    {
        $json = json_decode(file_get_contents(storage_path('data/users.json')), true);
        $collection =User::hydrate($json);
        $this->collection = $collection->flatten();
    }

    /**
     * Find user by name
     * @param $name
     * @return mixed
     */
    public function find($name)
    {
        return $this->collection->firstWhere('name', '=', $name);
    }

    /**
     * Validation of existing user
     * @param $name
     * @param $password
     * @return bool
     */
    public function validate($name, $password)
    {
       foreach ($this->collection as $user){
           if($user->name == $name && $user->password == $password){
               return true;
           }
       }
       return false;
    }
}
