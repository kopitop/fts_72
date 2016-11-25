<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Models\User';
    }

    public function updateProfile(array $data, $id, $attribute = 'id', $withSoftDeletes = false)
    {
        try {

            if ($withSoftDeletes) {
                $this->newQuery()->eagerLoadTrashed();
            }

            $user = $this->model->find($id);
            $fillable = $this->model->getFillable();
            $data = array_only($data, $fillable);
            $user->fill($data);

            if (!$user->save()) {
                throw new Exception(trans('common/messages.update_error'));
            }

            return true;
        } catch (Exception $e){

            return redirect()->action('Web\UsersController@edit', ['id' => $id])
            ->withErrors(trans('common/messages.update_error'));
        }
    }

}
