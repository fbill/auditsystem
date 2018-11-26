<?php
/**
 * Created by PhpStorm.
 * User: Franco
 * Date: 22/10/2018
 * Time: 05:13 PM
 */

namespace App\Repositories;


interface Crud
{
    public function all();

    public function create(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function show($id);
}