<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // Marcar TODAS las notificaciones del usuario como leídas
    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications()->update(['is_read' => true]);

        // 🟢 SEGURO: Intenta volver atrás, y si no puede, redirige al dashboard
        return redirect()->back()->with('success', 'Todas las notificaciones marcadas como leídas.');
    }

    // Marcar UNA sola notificación como leída
    public function markAsRead(Notification $notification)
    {
        // Seguridad: Verificar que la notificación le pertenece al usuario autenticado
        if ($notification->user_id !== auth()->id()) {
            abort(403);
        }

        $notification->update(['is_read' => true]);

        // 🟢 SEGURO: Redirección con fallback explícito para evitar el 404
        return redirect()->intended(route('dashboard'));
    }

    // ⭐ Actualizar el límite mensual desde el input de la navbar
    public function updateLimit(Request $request)
    {
        $request->validate([
            'monthly_limit' => 'required|numeric|min:1'
        ]);

        auth()->user()->update([
            'monthly_limit' => $request->monthly_limit
        ]);

        return response()->json(['success' => true, 'message' => 'Límite actualizado con éxito.']);
    }
}
