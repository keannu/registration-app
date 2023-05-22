<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\CreateAndUpdateUserRequest;
use App\Http\Requests\User\GetUserRequest;
use App\Http\Requests\User\UserLoginRequest;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;

/**
 * Class UserController
 * 
 * @author Keannu Rim Kristoffer C. Regala <keannu>
 * @since 2023.05.06
 * @version 1.0
 */
class UserController
{
    /**
     * @var UserService $oUserService
     */
    private $oUserService;

    /**
     * UserController constructor.
     * @param UserService $oUserService
     */
    public function __construct(UserService $oUserService)
    {
        $this->oUserService = $oUserService;
    }

    /**
     * loginUser
     * @param UserLoginRequest $oUserLoginRequest
     * @return JsonResponse
     */
    public function loginUser(UserLoginRequest $oUserLoginRequest)
    {
        $aResult = $this->oUserService->loginUser($oUserLoginRequest->validated());
        
        return response()->json($aResult['data'], $aResult['code']);
    }

    /**
     * logoutUser
     * @return JsonResponse
     */
    public function logoutUser()
    {
        $aResult = $this->oUserService->logoutUser();
        
        return response()->json($aResult['data'], $aResult['code']);
    }

    /**
     * createUser
     * @param CreateAndUpdateUserRequest $oCreateAndUpdateUserRequest
     * @return JsonResponse
     */
    public function createUser(CreateAndUpdateUserRequest $oCreateAndUpdateUserRequest)
    {
        $aResult = $this->oUserService->createUser($oCreateAndUpdateUserRequest->validated());
        
        return response()->json($aResult['data'], $aResult['code']);
    }

    /**
     * updateUser
     * @param int $iUserNo
     * @param CreateAndUpdateUserRequest $oCreateAndUpdateUserRequest
     * @return JsonResponse
     */
    public function updateUser(int $iUserNo, CreateAndUpdateUserRequest $oCreateAndUpdateUserRequest)
    {
        $aResult = $this->oUserService->updateUser($iUserNo, $oCreateAndUpdateUserRequest->validated());
        
        return response()->json($aResult['data'], $aResult['code']);
    }

    /**
     * deleteUser
     * @param int $iUserNo
     * @return JsonResponse
     */
    public function deleteUser(int $iUserNo)
    {
        $aResult = $this->oUserService->deleteUser($iUserNo);
        
        return response()->json($aResult['data'], $aResult['code']);
    }

    /**
     * getUserList
     * @param GetUserRequest $oGetUserRequest
     * @return JsonResponse
     */
    public function getUserList(GetUserRequest $oGetUserRequest)
    {
        $aResult = $this->oUserService->getUserList($oGetUserRequest->validated());
        
        return response()->json($aResult['data'], $aResult['code']);
    }

    /**
     * getUserByNo
     * @return JsonResponse
     */
    public function getUserByNo()
    {
        $aResult = $this->oUserService->getUserByNo();
        
        return response()->json($aResult['data'], $aResult['code']);
    }
}
