<?php

namespace Developez\LaraFileAuth;

use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\User as UserContract;

use Illuminate\Auth\GenericUser;
use Illuminate\Hashing\HashManager;
use Illuminate\Contracts\Eloquent;

use Developez\LaraFileAuth\StorageEngineContract;
use Developez\LaraFileAuth\UserFile;

class AuthFileProvider implements UserProvider
{
    private $storage;
    private $hasher;

    public function __construct(
        StorageEngine $storage,
        HashManager $hasher,
        Model $model = new GenericUser()
    )
    {
        $this->storage = $storage;
        $this->hasher  = $hasher;
        $this->model   = $model;
    }

    public function retrieveById($identifier)
    {
        return $this->parseToModel(
            $this->storage->findUserById($identifier)
        );
    }

    public function retrieveByToken($identifier, $token)
    {
        return $this->parseToModel(
            $this->storage->findUserByToken($identifier, $token);
        );
    }

    public function updateRememberToken(Authenticatable $user, $token)
    {
        return $user->setRememberToken($token);
    }

    public function retrieveByCredentials(array $credentials)
    {
        return $this->parseToModel(
            $this->storage->findUser($credentials['email']);
        );
    }

    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        if($this->hasher->check($user->password, $credentials['password']))
            return true;

        return throw new Exception("Login error!", 403);
    }

    private function parseToModel(UserFile $user)
    {
        return $this->model([
            'id'             => $user->getIdentifier(),
            'identifier'     => $user->getIdentifier(),
            'uuid'           => $user->getUUID(),
            'name'           => $user->getName(),
            'email'          => $user->getEmail(),
            'password'       => $user->getPassword(),
            'rol'            => $user->getRol(),
            'status'         => $user->getStatus(),
            //'remember_token' => str_random(60)
        ]);
    }
}
