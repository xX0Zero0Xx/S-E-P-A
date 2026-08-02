public function authenticated(Request $request, $user)
{
    if ($user->rol === 'administrador') {
        return redirect()->route('admin.dashboard');
    }

    if ($user->rol === 'capturista') {
        return redirect()->route('capturista.dashboard');
    }

    return redirect('/');
}