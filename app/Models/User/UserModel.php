<?php

namespace App\Models\User;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Arr;

/**
 * Class UserModel
 * 
 * @author Keannu Rim Kristoffer C. Regala <keannu>
 * @since 2023.05.18
 */
class UserModel
{
    /**
     * @const TABLE_NAME string
     */
    const TABLE_NAME = 'users';

    /***
     * @var array $aColumns
     */
    private $aColumns = [
        'user_no',
        'username',
        'email',
        'is_admin',
        'phone_no',
        'created_at',
        'updated_at'
    ];

    /**
     * UserModel constructor
     */
    public function __construct()
    {
    }

    /**
     * getUserList
     * @param array $aParameters
     * @return array
     */
    public function getUserList(array $aParameters) : array
    {
        $oQueryBuilder = DB::table(self::TABLE_NAME)
            ->select($this->aColumns)
            ->orderBy('created_at', 'desc')
            ->where('username', 'like', $this->getWhereValue($aParameters, 'username'))
            ->where('email', 'like', $this->getWhereValue($aParameters, 'email'));

        $sIsAdminValue = Arr::pull($aParameters, 'is_admin', '');
        if (empty($sIsAdminValue) === false && $sIsAdminValue !== 'A') {
            $oQueryBuilder->where('is_admin', $sIsAdminValue);
        }
    
        return $oQueryBuilder->get()
            ->toArray();
    }

    /**
     * getWhereValue
     * @param array $aParameters
     * @param string $sKey
     * @return string
     */
    private function getWhereValue(array $aParameters, string $sKey) : string
    {
        $sValue = Arr::get($aParameters, $sKey, '');
        if (empty($sValue) === false) {
            return '%' . $sValue . '%';
        }

        return '%';
    }

    /**
     * getUserByNo
     * @param int $iUserNo
     * @return array
     */
    public function getUserByNo(int $iUserNo) : array
    {
        return (array) DB::table(self::TABLE_NAME)
            ->select(array_merge($this->aColumns, [ 'password' ]))
            ->where('user_no', $iUserNo)
            ->first();
    }

    /**
     * getUserLoginInfo
     * @param string $sUsernameOrEmail
     * @return array
     */
    public function getUserLoginInfo(string $sUsernameOrEmail) : array
    {
        return (array) DB::table(self::TABLE_NAME)
            ->select(array_merge($this->aColumns, [ 'password' ]))
            ->where('username', $sUsernameOrEmail)
            ->orWhere('email', $sUsernameOrEmail)
            ->first();
    }

    /**
     * createUser
     * @param array $aUserInfo
     * @return string
     */
    public function createUser(array $aUserInfo) : string
    {
        try {
            DB::table(self::TABLE_NAME)
                ->insert($aUserInfo);

            return 'success';
        } catch(QueryException $oException) {
            return (string) $oException->getMessage();
        };
    }

    /**
     * updateUser
     * @param int $iUserNo
     * @param array $aUserInfo
     * @return mixed
     */
    public function updateUser(int $iUserNo, array $aUserInfo)
    {
        try {
            $aUserInfo['updated_at'] = DB::raw('CURRENT_TIMESTAMP');
            return (bool) DB::table(self::TABLE_NAME)
                ->where('user_no', $iUserNo)
                ->update($aUserInfo);
        } catch(QueryException $oException) {
            return (string) $oException->getMessage();
        };
    }

    /**
     * deleteUser
     * @param int $iUserNo
     * @return bool
     */
    public function deleteUser(int $iUserNo) : bool
    {
        return (bool) DB::table(self::TABLE_NAME)
            ->where('user_no', $iUserNo)
            ->delete();
    }
}
