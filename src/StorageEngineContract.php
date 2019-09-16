<?php

namespace Developez\LaraFileAuth;

interface StorageEngineContract
{
    public function readFile();
    public function saveFile();
}