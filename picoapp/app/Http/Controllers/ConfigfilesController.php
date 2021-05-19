<?php

namespace App\Http\Controllers;

use App\Models\Configfile;
use Exception;
use Illuminate\Http\Request;

class ConfigfilesController extends Controller
{
    /**
     * Display a listing of configuration files.
     */
    public function index()
    {
        $this->authorize('view-configfiles');

        return view('configfiles.index', [
            'files' => Configfile::all()
        ]);
    }

    /**
     * Show the form for creating a new configuration file.
     */
    public function create()
    {
        $this->authorize('create-configfile');

        return view('configfiles.create');
    }

    /**
     * Store a newly created configuration file in storage.
     * Create file in system
     */
    public function store(Request $request)
    {
        $this->authorize('store-configfile');

        request()->validate([
            'name' => ['required', 'unique:configfiles,name'],
            'description' => 'required',
            'content' => 'required',
        ]);

        $content = request('content');
        $file = new Configfile();
        $file->name = request('name');
        $file->description = request('description');
        $file->filepath = "nixops-files/" . $file->name;

        try{
            // create file in system
             $tmp_file = file_put_contents($file->filepath, $content.PHP_EOL , LOCK_EX);
            // save information to databse
            $file->save();
        }
        catch (Exception $e){
            return redirect()->to('/configfiles')->with(
                ['message' => 'Process of creating new configuration file ' . $file->name . ' was not successfull.',
                 'alert' => 'alert-danger']);
        }

        return redirect()->to('/configfiles')->with(
            ['message' => 'Configuration file '. $file->name . ' was successfully created.',
             'alert' => 'alert-success']);
    }

    /**
     * Show the specified configuration file.
     */
    public function show(Configfile $configfile)
    {
        $this->authorize('show-configfile', [$configfile]);
        $content = file_get_contents($configfile->filepath);

        return view('configfiles.show', ['configfile' => $configfile, 'configfileContent' => $content]);
    }

    /**
     * Show the form for editing the specified configuration file.
     */
    public function edit(Configfile $configfile)
    {
        $this->authorize('edit-configfile', [$configfile]);
        $content = file_get_contents($configfile->filepath);

        return view('configfiles.edit', ['configfile' => $configfile, 'configfileContent' => $content]);
    }

    /**
     * Update the specified configuration file in storage and change file contents on disk.
     */
    public function update(Request $request, Configfile $configfile)
    {
        $this->authorize('update-configfile');

        request()->validate([
            'name' => 'required',
            'description' => 'required',
            'content' => 'required',
        ]);

        $content = request('content');
        $configfile->name = request('name');
        $configfile->description = request('description');

        $redirect_path = "/configfiles/" . $configfile->id . "/show";

        try{
            // write to file
            file_put_contents($configfile->filepath, $content.PHP_EOL, LOCK_EX);
            // save information to databse
            $configfile->save();
        }
        catch (Exception $e){
            return redirect()->to($redirect_path)->with(
                ['message' => 'Process of updating configuration file ' . $configfile->name . ' was not successfull.',
                 'alert' => 'alert-danger']);
        }

        return redirect()->to($redirect_path)->with(
            ['message' => 'Configuration file '. $configfile->name . ' was successfully updated.',
             'alert' => 'alert-success']);

    }

    /**
     * Remove the specified configuration file from storage and from system.
     */
    public function destroy(Configfile $configfile)
    {
        $this->authorize('delete-configfile');

        $name = $configfile->name;

        try{
            unlink($configfile->filepath);
            $configfile->delete();
        }
        catch (Exception $e){
            return redirect()->to('/configfiles')->with(
                ['message' => 'Process of deleting configuration file ' . $name . ' was not successfull due to an error.',
                 'alert' => 'alert-danger']);
        }

        return redirect()->to('/configfiles')->with(
            ['message' => 'File '. $name . ' was successfully deleted.',
             'alert' => 'alert-success']);
    }
}
