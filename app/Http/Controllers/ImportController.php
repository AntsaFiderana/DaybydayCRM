<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\import\ImportService;
use Dotenv\Exception\ValidationException;
use Illuminate\Support\Facades\DB;

class ImportController extends Controller
{
    public function index()
    {
        return view('upload.index');
    }
    public function upload(Request $request)
    {
        try {
            $request->validate([
                'file1'=>'required|file|mimes:csv,txt',

            ]);
            $csvfile1=$request->file('file1');
            DB::beginTransaction();
            $myimportservice=new ImportService();

            $myimportservice->handlefile1($csvfile1);
            DB::commit();
            session()->flash('flash_message', __('Files successfully imported'));
        }
        catch (ValidationException $e)
        {
            DB::rollback();
            session()->flash('flash_message_warning', $e->getMessage());
        }
        catch (\Exception $e)
        {
            DB::rollback();
            session()->flash('flash_message_warning', $e->getMessage());
        }

        return redirect()->back();
    }
}