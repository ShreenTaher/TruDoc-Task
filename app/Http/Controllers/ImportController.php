<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImportRequest;
use App\Imports\UsersImport;
use Excel;

class ImportController extends Controller
{
    public function store(ImportRequest $request)
    {
        $file = $request->file('file');

        Excel::queueImport(new UsersImport, $file);

        return back()->with('success', 'import in queue, we will sent notification after import finished.');
    }
}
