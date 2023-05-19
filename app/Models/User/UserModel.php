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
 * @version 1.0
 */
class UserModel
{
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
        $oQueryBuilder = DB::table('users')
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
     * @param array $aParameters
     * @return array
     */
    public function getUserByNo(array $aParameters) : array
    {
        return [];
    }

    /**
     * getUserLoginInfo
     * @param string $sUsernameOrEmail
     * @return array
     */
    public function getUserLoginInfo(string $sUsernameOrEmail) : array
    {
        return (array) DB::table('users')
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
            DB::table('users')
                ->insert($aUserInfo);

            return 'success';
        } catch(QueryException $oException) {
            return (string) $oException->getMessage();
        };
        
    }
}
