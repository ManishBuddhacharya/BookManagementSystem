<?php
 
namespace App\Repository;

interface BaseRepoInterface
{
    public function all();

    public function find($id);
    
    public function save(array $data);

    public function update(int $id, array $data);

    public function softDelete(int $id);

    public function destroy(int $id);
}
