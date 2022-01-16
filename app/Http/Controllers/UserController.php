<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(): Response
    {
        $this->authorize('dashboard', User::class);

        return Inertia::render('Users', [
            'users' => $this->userService->all()
        ]);
    }

    public function toggleDashboardAccess(int $id)
    {
        $this->authorize('updateAccess', User::class);

        throw_if(
            Auth::user()->id === $id,
            new UnprocessableEntityHttpException('Não é possível atualizar seu próprio registro.')
        );

        return response()->json($this->userService->toggleDashboardAccess($id));
    }
}
