<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    // POST /api/auth/register
    public function register(Request $request)
    {
        $data = $request->validate([
            'name'         => 'required|string',
            'email'        => 'required|email|unique:users',
            'password'     => 'required|string|min:6',
            'phone'        => 'nullable|string',
            'country'      => 'nullable|string',
            'referralCode' => 'nullable|string',
        ]);

        $referredBy = null;
        if (!empty($data['referralCode'])) {
            $referrer = User::where('referral_code', $data['referralCode'])->first();
            if ($referrer) {
                $referredBy = $referrer->id;
            }
        }

        $user = User::create([
            'name'        => $data['name'],
            'email'       => $data['email'],
            'password'    => $data['password'],
            'phone'       => $data['phone'] ?? null,
            'country'     => $data['country'] ?? null,
            'referred_by' => $referredBy,
        ]);

        if ($referredBy) {
            User::where('id', $referredBy)->increment('total_downlines');
        }

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'token' => $token,
            'user'  => [
                'id'           => $user->id,
                '_id'          => $user->id,
                'name'         => $user->name,
                'email'        => $user->email,
                'role'         => $user->role,
                'referralCode' => $user->referral_code,
            ],
        ], 201);
    }

    // POST /api/auth/login
    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response()->json(['message' => 'Invalid email or password'], 401);
        }

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'token' => $token,
            'user'  => [
                'id'           => $user->id,
                '_id'          => $user->id,
                'name'         => $user->name,
                'email'        => $user->email,
                'role'         => $user->role,
                'referralCode' => $user->referral_code,
            ],
        ]);
    }

    // GET /api/auth/me
    public function me()
    {
        $user = JWTAuth::parseToken()->authenticate();
        $user->load('referredBy:id,name,email');
        return response()->json($user->makeHidden('password'));
    }

    // PUT /api/auth/profile
    public function updateProfile(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $data = $request->only(['name', 'phone', 'country', 'bio', 'dxnMemberId']);

        $user->update([
            'name'          => $data['name'] ?? $user->name,
            'phone'         => $data['phone'] ?? $user->phone,
            'country'       => $data['country'] ?? $user->country,
            'bio'           => $data['bio'] ?? $user->bio,
            'dxn_member_id' => $data['dxnMemberId'] ?? $user->dxn_member_id,
        ]);

        return response()->json($user->makeHidden('password'));
    }

    // PUT /api/auth/change-password
    public function changePassword(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $data = $request->validate([
            'currentPassword' => 'required|string',
            'newPassword'     => 'required|string|min:6',
        ]);

        if (!Hash::check($data['currentPassword'], $user->password)) {
            return response()->json(['message' => 'Current password is incorrect'], 400);
        }

        $user->password = $data['newPassword'];
        $user->save();

        return response()->json(['message' => 'Password updated successfully']);
    }

    // POST /api/auth/create-admin (admin only)
    public function createAdmin(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'phone'    => 'nullable|string',
            'country'  => 'nullable|string',
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => $data['password'],
            'phone'    => $data['phone'] ?? null,
            'country'  => $data['country'] ?? null,
            'role'     => 'admin',
        ]);

        return response()->json([
            'message' => 'Admin created successfully',
            'user'    => ['id' => $user->id, 'name' => $user->name, 'email' => $user->email, 'role' => $user->role],
        ], 201);
    }

    // GET /api/auth/users (admin only)
    public function getUsers()
    {
        $users = User::select('id', 'name', 'email', 'role', 'phone', 'country', 'referral_code', 'created_at')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn($u) => array_merge($u->toArray(), ['_id' => $u->id]));

        return response()->json($users);
    }

    // POST /api/auth/contact
    public function contact(Request $request)
    {
        $msg = ContactMessage::create($request->only(['name', 'email', 'phone', 'subject', 'message']));
        return response()->json(['message' => 'Message sent successfully', 'id' => $msg->id, '_id' => $msg->id], 201);
    }
}
