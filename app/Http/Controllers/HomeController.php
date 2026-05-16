<?php
namespace App\Http\Controllers;

class HomeController extends Controller {
    public function index() { return view('welcome'); }
    public function profil() { return view('profil'); }
    public function bantuan() { return view('bantuan'); }
    public function kontak() { return view('contact'); }
}
