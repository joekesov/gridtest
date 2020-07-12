<?php


namespace App\Http\Frontend\Dashboard;

use App\Application\UserInterface\Controller;
use Illuminate\Http\Request;
use App\Domain\Button\Service\ButtonService;
use App\Http\Frontend\Dashboard\Request\ButtonRequest;
use App\Http\Frontend\Dashboard\Request\AddButtonRequest;
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

    public function addForm(Request $request)
    {
        $model = null;
        $colorsCollection = $this->colorService->getAll();

        $view = 'Frontend/Dashboard::pages.add';
        if ($request->ajax()) {
            $view = '';
        }

        return view($view, compact('model','colorsCollection'));
    }

    public function add(AddButtonRequest $request)
    {
        $parameters = $request->except(['_method', '_token']);
        $model = $this->service->create($parameters);

        $message = 'A button has been successfully added!';

        return redirect(route('dashboard', []))
            ->with('status', $message);
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

        $message = 'Button has been successfully edited!';

        return redirect(route('dashboard', []))
            ->with('status', $message);
    }

    public function deleteForm(Request $request, int $id)
    {
        $model = $this->service->getById($id);

        $view = 'Frontend/Dashboard::pages.delete';
        if ($request->ajax()) {
            $view = '';
        }

        return view($view, compact('model'));
    }

    public function delete(Request $request, int $id)
    {
        $this->service->delete($id);

        $message = 'Deleted';

        return redirect(route('dashboard', []))
            ->with('status', $message);
    }
}
