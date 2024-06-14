<?php

namespace App\Http\Controllers;

use App\DataTables\UsuariosDatatables;
use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the FileType.
     *
     * @param UsuariosDatatables $UsuariosDatatables
     * @return Response
     */
    public function index(UsuariosDatatables $UsuariosDatatables)
    {
        // $this->isSuperAdmin();
        return $UsuariosDatatables->render('pages.usuarios.index');
    }


    public function create()
    {
        return view('pages.usuarios.create');
    }
}
