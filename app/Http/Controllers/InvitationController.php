<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

class InvitationController extends Controller
{
    public function index()
    {
        $invitations = Invitation::latest()->get();
        return view("invitations.index", compact("invitations"));
    }

    public function store(Request $request)
    {
        $request->validate([
            "email" => "required|email|unique:users,email",
        ]);

        $token = Str::random(32);

        // Se já existir um convite para este e-mail, atualizamos o token e a expiração
        // Caso contrário, criamos um novo.
        Invitation::updateOrCreate(
            ['email' => $request->email],
            [
                'token' => $token,
                'expires_at' => now()->addDays(7),
            ]
        );

        return back()->with("success", "Convite gerado/atualizado com sucesso!");
    }

    public function destroy(Invitation $invitation)
    {
        $invitation->delete();
        return back()->with("success", "Convite removido!");
    }
}
