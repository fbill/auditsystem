<?php
/**
 * Created by PhpStorm.
 * User: Franco
 * Date: 22/10/2018
 * Time: 05:15 PM
 */

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class Repository implements Crud
{

    protected $model;

    public function __construct()
    {
        $this->model = $this->getModel();
    }

    abstract public function getModel();

    public function all()
    {
        // TODO: Implement all() method.
        return $this->model->all();
    }

    public function create(array $data)
    {
        // TODO: Implement create() method.
    }

    public function update(array $data, $id)
    {
        // TODO: Implement update() method.
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    public function show($id)
    {
        return $this->model->find($id);
    }
}