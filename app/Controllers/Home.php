<?php
namespace App\Controllers;

use \Firebase\JWT\JWT;
use App\Controllers\Auth;
use CodeIgniter\RESTful\ResourceController;
 
header("Access-Control-Allow-Origin: * ");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
class Home extends ResourceController
{
    public function __construct()
    {
        $this->protect = new Auth();
    }
 
    public function index()
    {
        $secret_key = $this->protect->privateKey();
        $token = null;
        $authHeader = $this->request->getServer('HTTP_AUTHORIZATION');
        $arr = explode(" ", $authHeader);
        $token = $arr[1];
        if ($token) {
            try {
                $decoded = JWT::decode($token, $secret_key, array('HS256'));
         
                if ($decoded) {
                    switch ($decoded->data->role) {
                        case 'admin':
                            $output = [
                                'message' => 'token terverifikasi!',
                                'data' => $decoded->data->role
                            ];
                            return $this->respond($output, 200);
                            break;
                        case 'user':
                            $output = [
                                'message' => 'token terverifikasi!',
                                'data' => $decoded->data->role
                            ];
                            return $this->respond($output, 200);
                            break;
                    }
                }
            } catch (\Exception $e) {
                $output = [
                    'message' => 'token tidak terdaftar!',
                    "error" => $e->getMessage()
                ];
         
                return $this->respond($output, 401);
            }
        }
    }

    public function akses()
    {
        $secret_key = $this->protect->privateKey();
        $token = null;
        $authHeader = $this->request->getServer('HTTP_AUTHORIZATION');
        $arr = explode(" ", $authHeader);
        $token = $arr[1];
        if ($token) {
            try {
                $decoded = JWT::decode($token, $secret_key, array('HS256'));
         
                if ($decoded) {
                    switch ($decoded->data->role) {
                        case 'admin':
                            $output = [
                                'message' => 'selamat datang admin',
                                'data' => $decoded->data->role
                            ];
                            return $this->respond($output, 200);
                            break;
                        case 'user':
                            $output = [
                                'message' => 'user tidak dapat mengunjungi halaman ini',
                                'data' => $decoded->data->role
                            ];
                            return $this->respond($output, 500);
                            break;
                    }
                }
            } catch (\Exception $e) {
                $output = [
                    'message' => 'token tidak terdaftar!',
                    "error" => $e->getMessage()
                ];
         
                return $this->respond($output, 401);
            }
        }
    }

    public function logout()
    {
        $logout = $this->request->getPost('logout');
		if ($logout == 'yes') {
			helper('cookie');
			$this->session->sess_destroy();
			delete_cookie();
			$output = [
				'message' => 'Logout berhasil!'
			];
			return $this->respond($output, 200);
		}
    }
}
