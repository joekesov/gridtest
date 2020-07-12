<?php


namespace App\Http\Frontend\Dashboard;

use App\Application\UserInterface\Controller;
use Illuminate\Http\Request;
use App\Domain\Button\Service\ButtonService;
use App\Http\Frontend\Dashboard\Request\ButtonRequest;
use App\Domain\Color\Service\ColorService;

class DashboardController extends Controller
{
    private $service = null;
    private $colorService = null;

    public function __construct(ButtonService $service, ColorService $colorService)
    {
        $this->service = $service;
        $this->colorService = $colorService;
    }

    // TODO:
    public function index(Request $request)
    {
        $buttons = $this->service->getAll();

        return view('Frontend/Dashboard::pages.dashboard', compact('buttons'));
    }

    public function editForm(Request $request, int $id)
    {
        $model = $this->service->getById($id);

        $colorsCollection = $this->colorService->getAll();

        $view = 'Frontend/Dashboard::pages.edit';
        if ($request->ajax()) {
            $view = '';
        }

        return view($view, compact('model', 'colorsCollection'));
    }

    public function edit(ButtonRequest $request, int $id)
    {
        $parameters = $request->except(['_method', '_token']);

        $model = $this->service->update($id, $parameters);

        $message = 'Uspeh';

        return redirect(route('dashboard', []))
            ->with('status', $message);
    }
}
