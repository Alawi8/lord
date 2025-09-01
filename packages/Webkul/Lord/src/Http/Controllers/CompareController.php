<?php

namespace Webkul\Lord\Http\Controllers;

use Webkul\Attribute\Repositories\AttributeFamilyRepository;

class CompareController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(protected AttributeFamilyRepository $attributeFamilyRepository) {}

    /**
     * Address route index page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $comparableAttributes = $this->attributeFamilyRepository->getComparableAttributesBelongsToFamily();

        return view('lord::compare.index', compact('comparableAttributes'));
    }
}
