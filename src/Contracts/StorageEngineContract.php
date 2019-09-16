<?php

namespace Developez\LaraFileAuth\Contracts;

interface StorageEngineContract
{
    public function readFile();
    public function saveFile();
}