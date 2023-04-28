<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class ApiController extends BaseController
{
    public function index()
    {
        $data = ['message' => 'Welcome to the API'];
        return response()->json($data);
    }

    public function addCustomer()
    {
        $users = "Hello World";
        return response()->json($users);
    }

    // Add more methods to handle additional API endpoints
}
?>