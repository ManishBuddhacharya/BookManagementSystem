<?php
 
namespace App\Repository;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepo implements BaseRepoInterface
{
    protected $eloquent;
    protected $builder;

    public function __construct()
    {
        $this->eloquent = new User();
    }

    public function all()
    {
        return $this->eloquent->where('is_deleted', 0)->get();
    }


    public function find($id)
    {
        if (isset($this->eloquent->id) && $this->eloquent->id === (int) $id) {
            return $this->eloquent;
        }
        return $this->eloquent = $this->eloquent->find($id);
    }

    public function save(array $data = [])
    {
        $this->setAttributes($data);
        if (!$this->eloquent->exists):
            $this->eloquent->userc_id = auth()->id();
        endif;
        $this->eloquent->save();
        return $this->eloquent;
    }

    public function saveUpdate(array $data)
    {
        return $this->save($data);
    }

    public function update(int $id, array $data = [])
    {
        $find = $this->eloquent->find($id);
        foreach ($data as $key => $value) {
            $find->$key = $value;
        }
        $find->useru_id = auth()->id();
        $find->updated_at = date('Y-m-d H:i:s');
        $find->update();
        return $find;
    }
    
    public function softDelete(int $id)
    {
        $data = $this->eloquent->find($id);
        $data->is_deleted = 1;
        $data->userd_id = auth()->id();
        $data->deleted_at = date('Y-m-d H:i:s');
        $data->save();
        return $data;
    }
    
    public function destroy(int $id)
    {
        $data = $this->eloquent->find($id);
        $data->delete();
        return $data;
    }

    private function setAttributes($data)
    {
        foreach ($data as $key => $value) {
            $this->eloquent->$key = $value;
        }
    }
}
