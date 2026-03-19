<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class DistributorController extends Controller
{
    // GET /api/distributors/dashboard
    public function dashboard()
    {
        $user = JWTAuth::parseToken()->authenticate();

        $userFull = User::find($user->id);
        $downlines = User::where('referred_by', $user->id)
            ->select('id', 'name', 'email', 'created_at', 'total_downlines')
            ->get()
            ->map(fn($u) => array_merge($u->toArray(), ['_id' => $u->id]));

        $recentOrders = Order::with('items')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $totalOrders = Order::where('user_id', $user->id)->count();

        return response()->json([
            'user'         => $userFull->makeHidden('password'),
            'downlines'    => $downlines,
            'recentOrders' => $recentOrders,
            'totalOrders'  => $totalOrders,
        ]);
    }

    // GET /api/distributors/downlines
    public function downlines()
    {
        $user = JWTAuth::parseToken()->authenticate();

        $downlines = User::where('referred_by', $user->id)
            ->select('id', 'name', 'email', 'phone', 'country', 'created_at', 'total_downlines', 'total_sales', 'referral_code')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn($u) => array_merge($u->toArray(), ['_id' => $u->id]));

        return response()->json($downlines);
    }

    // GET /api/distributors/all (admin)
    public function all()
    {
        $distributors = User::with('referredBy:id,name,email')
            ->whereIn('role', ['distributor', 'user'])
            ->select('id', 'name', 'email', 'phone', 'country', 'role', 'referral_code', 'total_downlines', 'total_sales', 'referred_by', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn($u) => array_merge($u->toArray(), ['_id' => $u->id]));

        return response()->json($distributors);
    }

    // PUT /api/distributors/:id/role (admin)
    public function updateRole(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $user->update(['role' => $request->role]);
        return response()->json($user->makeHidden('password'));
    }

    // GET /api/distributors/referral-link
    public function referralInfo()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $clientUrl = env('CLIENT_URL', 'http://localhost:5173');
        $referralLink = "{$clientUrl}/register?ref={$user->referral_code}";

        return response()->json([
            'referralCode' => $user->referral_code,
            'referralLink' => $referralLink,
        ]);
    }
}
