<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatAIController extends Controller
{
    public function chat(Request $request)
    {
        $message = strtolower($request->message);

        if(str_contains($message,'garansi'))
        {
            return response()->json([
                'reply' =>
                'Untuk klaim garansi silakan masuk ke menu Klaim Garansi dan masukkan nomor serial produk.'
            ]);
        }

        if(str_contains($message,'produk'))
        {
            return response()->json([
                'reply' =>
                'Kami menyediakan Aluminium Anode dan Zinc Anode berkualitas tinggi.'
            ]);
        }

        if(str_contains($message,'tracking'))
        {
            return response()->json([
                'reply' =>
                'Silakan masuk ke menu Tracking Pesanan untuk melihat status produksi.'
            ]);
        }

        return response()->json([
            'reply' =>
            'Mohon jelaskan pertanyaan Anda lebih detail.'
        ]);
    }
}