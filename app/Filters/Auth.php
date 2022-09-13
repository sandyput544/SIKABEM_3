<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

use \App\Models\MenusModel;
use \App\Models\PositionMenuModel;

class Auth implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */
    protected $menus_model;
    protected $posmenu_model;
    public function __construct()
    {
        $this->menus_model = new MenusModel();
        $this->posmenu_model = new PositionMenuModel();
    }
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('is_logged_in')) {
            return redirect()->to(base_url('auth/'));
        } else {
            $curr_url = current_url(true);
            $uri = new \CodeIgniter\HTTP\URI($curr_url);
            $getUri = $uri->getSegment(1);

            if ($getUri === "profil") {
                redirect()->to(base_url('/profil'));
            } elseif ($getUri === "koleksi") {
                redirect()->to(base_url('/koleksi'));
            } else {
                // $db =  \Config\Database::connect();
                // Ambil data session id_jabatan lalu cek dengan uri segment dan mengambil data menu id
                // $kd_jbt = session('id_jabatan');
                // Ambil menu id
                // $kd_menu = $db->query('
                // SELECT kd_menu FROM menus WHERE url_menu="' . $getUri . '"
                // ');
                // $get_posmenu = $db->query('
                // SELECT * FROM position_menu WHERE kd_jabatan="' . $kd_jbt . '" AND kd_menu="' . $kd_menu . '"
                // ');

                // Ambil kd_menu
                $getMenu = $this->menus_model->where('url_menu', $getUri)->first();
                // Ambil posmenu
                $getPosMenu = $this->posmenu_model->where(['kd_jabatan' => session('id_jabatan'), 'kd_menu' => $getMenu['kd_menu']])->get();

                if ($getPosMenu->getNumRows() < 1) {
                    return redirect()->to(base_url('auth/blocked'));
                }
            }
        }
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
