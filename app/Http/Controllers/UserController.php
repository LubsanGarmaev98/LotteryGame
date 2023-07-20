<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserRequest  $request
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = User::query()->create([
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);

        return response()->json([
            'data' => $user,
            'result' => 'Success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     */
    public function showAllUsers(): JsonResponse
    {
        $users = User::with('lotteryGameMatch')->get();

        return response()->json([
            'data'   => $users,
            'result'    => 'Success'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request, int $id): JsonResponse
    {
        $data = $request->validated();

        /** @var User $user */
        $user = auth()->user();

        if (empty($data) && $user->getAuthIdentifier() != $id) {
            return response()->json([
                'error' => 'There is nothing to update or id don\'t match'
            ]);
        }

        if (!$user->isDirty()) {
            return response()->json([
                'data'      => 'There is nothing to update',
                'result'    => 'Success'
            ]);
        }

        $user->update($data);
        $user->save();

        return response()->json([
            'data'      => $user,
            'result'    => 'Success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function delete(int $id): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();
        if ($user->getAuthIdentifier() != $id) {
            return response()->json([
                'error' => 'Id don\'t match'
            ]);
        }

        try {
            $user->delete();
        } catch (\Exception $exception)
        {
            return response()->json([
                'error' => $exception->getMessage(),
            ]);
        }

        return response()->json([
            'data' => 'Пользователь успешно удален',
            'result'    => 'Success'
        ]);
    }
}
