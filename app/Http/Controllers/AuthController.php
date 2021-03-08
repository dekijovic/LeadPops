<?php


namespace App\Http\Controllers;


use App\Http\Resources\TokenResource;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Service\JWT;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;

class AuthController extends Controller
{


    public function token(Request $request)
    {
        $name = $request->get('name');
        $password = $request->get('password');
        $repo = new UserRepository();
        if(!$repo->validate($name, $password)){
            // Prefered way throw new ValidationException('Credentials are Invalid');
           return response(['message'=> 'Credentials are Invalid']);
        }
        $jwt = new JWT();
        $token = $jwt->generate($repo->find($name));

        return new TokenResource(['token' => $token]);

    }
}
