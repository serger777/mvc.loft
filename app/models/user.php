<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model as Model;

class User extends Model
{
    protected $table = 'users';
    protected $fillable = ['login', 'password', 'name', 'age', 'avatar_path', 'description'];

    /**
     * Возвращает массив с информацией о всех пользователях
     * @return array
     */
    public static function getAllUsers()
    {
        $users = User::all()->toArray();
        return $users;
    }

    /**
     * Возвращает массив с информацией о всех пользователях с сортировкой по возрасту.
     * @param $typeSort - строка 'asc' или 'desc'
     * @return array
     */
    public static function getUsersSortByAge($typeSort)
    {
        if ($typeSort != 'asc' && $typeSort != 'desc') {
            $typeSort = 'asc';
        }
        $users = User::where('id', '>', 1)->orderBy('age', $typeSort)->get()->toArray();
        return $users;
    }

    /**
     * Создает нового пользователя в базе данных
     * @param $login
     * @param $password
     * @param $name
     * @param $age
     * @param $description
     * @param $avatarPath
     * @return mixed
     */
    public static function createUser($login, $password, $name, $age, $description, $avatarPath)
    {
        $user = User::create([
            'login' => $login,
            'password' => $password,
            'name' => $name,
            'age' => $age,
            'description' => $description,
            'avatar_path' => $avatarPath
        ]);
        return $user;
    }

    /**
     * Возвращает объект-пользователя по его логину
     * @param $login
     * @return mixed
     */
    public static function getByLogin($login)
    {
        $user = User::where('login', '=', $login)->first();
        return $user;
    }

    /**
     * Возвращае id пользователя по его логину
     * @param $login
     * @return int
     */
    public static function getIdByLogin($login)
    {
        $user = User::where('login', '=', $login)->first();
        if ($user) {
            return $user->id;
        } else {
            return 0;
        };
    }

    public static function isExists($login)
    {
        $user = User::getByLogin($login);

        if ($user) return true;
        return false;
    }

    public static function getPasswordHash($login)
    {
        $user = User::where('login', '=', $login)->first();
        if ($user) {
            return $user->password;
        };
        return '';
    }

}
