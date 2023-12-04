<?php

namespace App\Http\Controllers\api\v1;

use App\Exceptions\ForbiddenException;
use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\ShareAccess;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserShareAccessController extends Controller
{
    protected function checkAccess(int $user_id): \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
    {
        $share = ShareAccess::query()
            ->where('user_id', $user_id)
            ->where('consumer_id', Auth::user()->id)
            ->first();

        if(!$share) {
            throw new ForbiddenException();
        }

        return $share;
    }

    /**
     * @throws ForbiddenException
     */
    public function index(User $user): JsonResponse
    {
        $share = $this->checkAccess($user->id);
        return response()->json([
            'data' => $share->user->cars
        ])->setStatusCode(200);
    }
}
