<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Set;
use App\Models\Data;

class DataApiController extends Controller
{

    private function getRequestData(Request $request, string $fieldName):mixed {
        $value = $request->get($fieldName);
        if (empty($value)) {
            $value = json_decode($request->get($fieldName), true);
        }
        if (empty($value)) {
            $value = json_decode($request->getContent(), true)[$fieldName] ?? null;
        }
        return $value;
    }

    public function get(Request $request):JsonResponse
    {
        $user = User
            ::where('api_token', $request->route('token'))
            ->first();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'wrong api token',
            ]);
        }

        $set = Set
            ::where('id', $request->route('set_id'))
            ->where('user', $user->id)
            ->limit(1)
            ->get(['id', 'name'])
            ->toArray();

        if (empty($set[0])) {
            return response()->json([
                'status' => false,
                'message' => 'set not found',
            ]);
        }

        $value = Data::where('set', $set[0]['id'])
            ->where('code', $this->getRequestData($request, 'code'))
            ->get(['value'])
            ->toArray();

        if (empty($value[0]['value'])) {
            return response()->json([
                'status' => false,
                'message' => 'data not found',
            ]);
        }

        return response()->json([
            'status' => true,
            'value' => $value[0]['value'],
        ]);
    }

    public function set(Request $request):JsonResponse
    {
        $user = User
            ::where('api_token', $request->route('token'))
            ->first();
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'wrong api token',
            ]);
        }

        $set = Set
            ::where('id', $request->route('set_id'))
            ->where('user', $user->id)
            ->limit(1)
            ->get(['id'])
            ->toArray();

        if (empty($set[0])) {
            return response()->json([
                'status' => false,
                'message' => 'data not found',
            ]);
        }

        Data::updateOrCreate([
            'set' => $set[0]['id'],
            'code' => $this->getRequestData($request, 'code'),
            'value' => $this->getRequestData($request, 'value'),
        ]);

        return response()->json([
            'status' => true
        ]);
    }
}
