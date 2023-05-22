<?php

namespace App\Services\User;

use App\Models\User\UserModel;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;


/**
 * Class UserService
 * 
 * @author Keannu Rim Kristoffer C. Regala <keannu>
 * @since 2023.05.18
 */
class UserService
{

    /**
     * @var UserModel $oUserModel
     */
    private $oUserModel;

    /**
     * @const int CACHE_TTL
     * Cache retention period : 15 minutes
     */
    const CACHE_TTL = 900;

    /**
     * PlaceInformationService constructor.
     * @param UserModel $oUserModel
     */
    public function __construct(UserModel $oUserModel)
    {
        $this->oUserModel = $oUserModel;
    }

    /**
     * loginUser
     * @param array $aParameter
     * @return array
     */
    public function loginUser(array $aParameter) : array
    {
        $aUser = $this->oUserModel->getUserLoginInfo(Arr::get($aParameter, 'username', ''));
        if (empty($aUser) === true) {
            return [
                'code' => 422,
                'data' => [
                    'message' => 'User do not exist. Please try again.'
                ]
            ];
        }

        if (Crypt::decrypt(Arr::get($aUser, 'password')) !== Arr::get($aParameter, 'password')) {
            return [
                'code' => 422,
                'data' => [
                    'message' => 'Password incorrect. Please try again.'
                ]
            ];
        }

        Cache::put([
            'user_no'  => Arr::get($aUser, 'user_no', 0),
            'username' => Arr::get($aUser, 'username', ''),
            'is_admin' => Arr::get($aUser, 'is_admin', 'F')
        ], self::CACHE_TTL);

        return [
            'code' => 200,
            'data' => [
                'message' => 'Login Successful!'
            ]
        ];
    }

    /**
     * createUser
     * @param array $aUserInfo
     * @return array
     */
    public function createUser(array $aUserInfo) : array
    {
        $aUserInfo['password'] = Crypt::encrypt(Arr::get($aUserInfo, 'password'));
        $sInsertStatus = $this->oUserModel->createUser($aUserInfo);
        if ($sInsertStatus === 'success') {
            return [
                'code' => 200,
                'data' => [
                    'message' => 'User created successfully.'
                ]
            ];
        }

        if (Str::contains($sInsertStatus, 'Duplicate') === true) {
            return [
                'code' => 422,
                'data' => [
                    'message' => 'User create failed. Username and email must be unique.'
                ]
            ];
        }

        return [
            'code' => 500,
            'data' => [
                'message' => 'User create failed. Please try again.'
            ]
        ];
    }

    /**
     * updateUser
     * @param int $iUserNo
     * @param array $aUserInfo
     * @return array
     */
    public function updateUser(int $iUserNo, array $aUserInfo) : array
    {
        if (Arr::pull($aUserInfo, 'is_password_change', 'F') === 'T') {
            $aUserInfo['password'] = Crypt::encrypt(Arr::get($aUserInfo, 'password'));
        }
        
        $mUpdateResult = $this->oUserModel->updateUser($iUserNo, $aUserInfo);
        if (is_string($mUpdateResult) === true) {
            return [
                'code' => 422,
                'data' => [
                    'message' => 'User update failed. Username and email should be unique.'
                ]
            ];
        }

        if ($mUpdateResult === false) {
            return [
                'code' => 500,
                'data' => [
                    'message' => 'User update failed. Please try again.'
                ]
            ];
        }

        return [
            'code' => 200,
            'data' => [
                'message' => 'User update successful.'
            ]
        ];
    }

    /**
     * deleteUser
     * @param int $iUserNo
     * @return array
     */
    public function deleteUser(int $iUserNo) : array
    {
        if ($this->oUserModel->deleteUser($iUserNo) === false) {
            return [
                'code' => 500,
                'data' => [
                    'message' => 'User delete failed.'
                ]
            ];
        }

        Cache::flush();
        return [
            'code' => 200,
            'data' => [
                'message' => 'User delete successful.'
            ]
        ];
    }

    /**
     * getUserList
     * @param array $aParameter
     * @return array
     */
    public function getUserList(array $aParameter) : array
    {
        return [
            'code' => 200,
            'data' => $this->oUserModel->getUserList($aParameter)
        ];
    }

    /**
     * getUserByNo
     * @param int $iUserNo
     * @return array
     */
    public function getUserByNo() : array
    {
        $aUserInfo = $this->oUserModel->getUserByNo(Cache::get('user_no', 0));
        if (empty($aUserInfo) === true) {
            return [
                'code' => 422,
                'data' => [
                    'message' => 'User does not exist. Please try again.'
                ]
            ];
        }

        $aUserInfo['password'] = Crypt::decrypt(Arr::get($aUserInfo, 'password'));
        return [
            'code' => 200,
            'data' => $aUserInfo
        ];
    }

    /**
     * logoutUser
     * @return array
     */
    public function logoutUser() : array
    {
        Cache::flush();

        return [
            'code' => 200,
            'data' => [
                'message' => 'Logout successful'
            ]
        ];
    }
}
