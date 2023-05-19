<?php

namespace App\Services\User;

use App\Models\User\UserModel;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;


/**
 * Class UserService
 * 
 * @author Keannu Rim Kristoffer C. Regala <keannu>
 * @since 2023.05.18
 * @version 1.0
 */
class UserService
{
    /**
     * @var UserModel $oUserModel
     */
    private $oUserModel;

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

        session()->put('username', Arr::get($aUser, 'username', ''));
        session()->put('is_admin', Arr::get($aUser, 'is_admin', ''));
        return [
            'code' => 200,
            'data' => [
                'message' => 'Login Successful!'
            ]
        ];
    }

    /**
     * loginUser
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
                    'message' => 'User create failed. Please check your data before trying again.'
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
     * @param array $aParameter
     * @return array
     */
    public function getUserByNo(array $aParameter) : array
    {
        return [
            'code' => 200,
            'data' => $this->oUserModel->getUserByNo($aParameter)
        ];
    }
}
