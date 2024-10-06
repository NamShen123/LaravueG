<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Models\CallSlip;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class CallSlipController extends Controller
{
    function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "book_ids" => "required",
                "deposit" => "required",
            ],
            [
                "book_ids.required" => "Phiếu mượn không có sách",
                "deposit.required" => "Khoản trả trước không được để trống",
            ]
        );

        if ($validator->fails()) {
            return response()->json($validator->errors(), Response::HTTP_BAD_REQUEST);
        }

        $user = $request->user();

        // Check valid book_ids
        $borrowBook = Books::whereIn('id', $request->book_ids)->get();
        if ($borrowBook->count() != count($request->book_ids)){
            $invalidBook = [];
            foreach ($request->book_ids as $bookId) {
                if (!in_array($bookId, $borrowBook->pluck('id')->all()) ) {
                    $invalidBook[] = $bookId;
                }
            }
            return response()->json([
                "message" => "Sách không hợp lệ",
                "invalid_book_ids" => $invalidBook
            ], Response::HTTP_CONFLICT);
        }

        $borringBook =  Books::borringByUser($user->id)->get();
        if (!$borringBook->isEmpty()) {
            $invalidBooks =  $borringBook->whereIn('id', $request->book_ids);
            if (!$invalidBooks->isEmpty()) {
                return response()->json([
                    "message" => "Phiếu có sách đã đăng ký",
                    "borrowed_book" => $borringBook,
                ]);
            }
        }


        $now = Carbon::now();
        $newCallSlip = new CallSlip;
        $newCallSlip->fill([
            'start' => $now,
            'end' => $now->addMonth(CallSlip::DEADLINE_MONTH),
            'created_at' => $now,
            'user_id' => $user->id,
            'deposit' => $request['deposit'],
            'status' => CallSlip::NEW,
        ]);

        $newCallSlip->save();
        $newCallSlip->books()->attach($request->book_ids);

        return response()->json([
            'message' => "Tạo phiếu mượn thành công"
        ]);
    }
}
