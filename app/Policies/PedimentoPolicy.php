<?php

namespace App\Policies;

use App\Models\Pedimento;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PedimentoPolicy
{
    /**
     * Determina si el usuario puede ver la lista de pedimentos.
     */
    public function viewAny(User $user): bool
    {
        // Los administradores ven todo, los capturistas ven sus propios registros
        return in_array($user->rol, ['administrador', 'capturista']);
    }

    /**
     * Determina si el usuario puede ver un pedimento específico.
     */
    public function view(User $user, Pedimento $pedimento): bool
    {
        // El administrador tiene acceso total; el capturista solo ve si él lo creó
        if ($user->rol === 'administrador') {
            return true;
        }

        return $user->id === $pedimento->user_id;
    }

    /**
     * Determina si el usuario puede crear pedimentos.
     * chingadera para controlar la insercion en la DB a nivel de permisos
     */
    public function create(User $user): bool
    {
        return in_array($user->rol, ['administrador', 'capturista']);
    }

    /**
     * Determina si el usuario puede actualizar el pedimento.
     */
    public function update(User $user, Pedimento $pedimento): bool
    {
        if ($user->rol === 'administrador') {
            return true;
        }

        return $user->id === $pedimento->user_id;
    }

    /**
     * Determina si el usuario puede eliminar el pedimento.
     */
    public function delete(User $user, Pedimento $pedimento): bool
    {
        // Solo administradores pueden eliminar pedimentos
        return $user->rol === 'administrador';
    }
}
