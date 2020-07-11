<?php


namespace App\Http\Frontend\Dashboard;

use App\Application\UserInterface\Controller;
use Illuminate\Http\Request;
use App\Domain\Button\Service\ButtonService;

class DashboardController extends Controller
{
    private $service = null;

    public function __construct(ButtonService $service)
    {
        $this->service = $service;
    }

    // TODO:
    public function index(Request $request)
    {
        $result = $this->service->getAll();
        foreach ($result as $button) {
            $color = $button->color;
//            print_r($color); exit;
        }

        return view('Frontend/Dashboard::dashboard');
    }
}
