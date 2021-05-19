<?php

namespace App\Http\Controllers;

use App\Models\Deployment;
use App\Models\Configfile;
use Illuminate\Http\Request;

class DeploymentsController extends Controller
{

    /**
     * Returns array of existing deployments in system.
     * Parse information from txt table to array.
     */
    public static function get_deployments_list()
    {
        $keys = ['pad', 'uuid', 'name', 'description', 'numof', 'type', 'pad']; // table header
        $command = 'nixops list 2>&1';

        $lines = null;
        $resultCode = null;
        $returnVal = exec($command, $lines, $resultCode);

        $str = implode('\n', $lines);
        $str = str_replace(' |', '|', $str);
        $str = str_replace('| ', '|', $str);
        $lines = explode('\n', $str);

        $num_of_dep = count($lines)-4; // 3 lines are header and 1 is footer

        $lines = array_slice($lines, 3, $num_of_dep); // delete first 3 rows

        $deps = [];
        foreach ($lines as $line) {
            array_push($deps, array_combine($keys, explode('|', $line)));
        }

        return $deps;
    }

    /**
     * Display a list of the created deployments.
     */
    public function index()
    {
        $this->authorize('view-deployments');

        $messx = null;

        $deployments = DeploymentsController::get_deployments_list();

        return view('deployments.index', [
            'messx' => $messx,
            'deployments_new' => $deployments
        ]);
    }

    /**
     * Deploy an existing deployment.
     */
    public function deploy(Request $request, $uuid)
    {
        $this->authorize('deploy-deployment');

        $command = 'nixops deploy -d ' . $uuid . ' -I /nix/var/nix/profiles/per-user/root/channels/nixos/';

        $lines = "output.txt";
        $resultCode = null;

        $pid = exec(sprintf("%s > %s 2>&1 & echo $! ", $command, $lines));

        $deployments = DeploymentsController::get_deployments_list();

        return redirect()->to('/deployments')->with([
            'pid' => $pid,
            'alert' => 'alert-danger'
        ]);
    }

    /**
     * Show the form for creating a new deployment.
     */
    public function create()
    {
        $this->authorize('create-deployment');

        return view('deployments.create', [
            'files' => Configfile::all()
        ]);
    }

    /**
     * Create new deployment in system
     */
    public function store(Request $request)
    {

        $this->authorize('store-deployment');

        request()->validate([
            'name' => ['required', 'unique:deployments,name'],
            'configFileName' => 'required',
        ]);

        $configFilePath = "nixops-files/" . request('configFileName');

        $deployment = new Deployment();
        $deployment->name = request('name');
        $deployment->configFileName = request('configFileName');

        $command = 'nixops create ' . $configFilePath . ' -d ' . $deployment->name . ' 2>&1';

        $output = null;
        $resultCode = null;
        $returnVal = exec($command, $output, $resultCode);

        if ($resultCode != 0) {
            $message = "An error occured while createing new deployment: ";
            $command_output = implode("\n", $output);
            return redirect()->to('/deployments/index')->with(
                ['message' => $message,
                 'output' => $command_output,
                 'alert' => 'alert-danger']);
        }
        else {
            $deployment->save();

            $message = "Deployment creation was successfull: ";
            $command_output = implode("\n", $output);
            return redirect()->to('/deployments')->with(
                ['message' => $message,
                 'output' => $command_output,
                 'alert' => 'alert-success']);
        }
    }


    /**
     * Show info about deployment.
     */
    public function info($uuid)
    {
        $this->authorize('seeinfo-deployment');

        $table_header_keys = ['pad', 'name', 'status', 'type', 'resource_id', 'ip', 'pad']; // table header

        $command = 'nixops info -d ' . $uuid . ' -I /nix/var/nix/profiles/per-user/root/channels/nixos/ 2>/dev/null';

        $output_lines = null;
        $result_code = null;
        $returnVal = exec($command, $output_lines, $result_code);

        if($result_code != 0) {
            $message = "An error occured while getting deployment info:";
            $command_output = implode("\n", $output_lines);
            return redirect()->to('/deployments')->with(
                ['message' => $message,
                 'output' => $command_output,
                 'alert' => 'alert-danger']);
        }

        // first six rows of output are text info
        $text_info = implode("\n", array_slice($output_lines, 0, 5));
        // following lines are table ascii table
        $table_info = implode("\n", array_slice($output_lines, 6));

        $table_info = str_replace(' |', '|', $table_info);
        $table_info = str_replace('| ', '|', $table_info);
        $lines = explode("\n", $table_info);

        $num_of_rows = count($lines)-4; // 3 lines are header and 1 is footer
        $lines = array_slice($lines, 3, $num_of_rows); // get only body without header and footer

        // create array from ascii table
        $table_rows = [];
        foreach ($lines as $line) {
            array_push($table_rows, array_combine($table_header_keys, explode('|', $line)));
        }

        return view('deployments.info', [
            'text_info' => $text_info,
            'table_rows' => $table_rows,
        ]);
    }

    /**
     * Check deployment state
     */
    public function check($uuid)
    {
        $this->authorize('check-deployment');

        $table_header_keys = ['pad', 'name', 'exists', 'up', 'reachable', 'disks', 'load', 'units', 'notes', 'pad'];

        $command = 'nixops check -d ' . $uuid . ' -I /nix/var/nix/profiles/per-user/root/channels/nixos';

        $output_lines = null;
        $result_code = null;
        $returnVal = exec($command, $output_lines, $result_code);

        if ($result_code == 4)  {
            $message = "Deployment is not reachable. Can not check its status.";
            $command_output = implode("\n", $output_lines);
            return redirect()->to('/deployments')->with(
                ['message' => $message,
                 'alert' => 'alert-danger']);
        }
        if ($returnVal == false) {
            $message = "An error occured while checking deployment:";
            $command_output = implode("\n", $output_lines);
            return redirect()->to('/deployments')->with(
                ['message' => $message,
                 'output' => $command_output,
                 'result_code' => $result_code,
                 'alert' => 'alert-danger']);
        }


        $output_lines = implode("\n", $output_lines);
        $output_lines = str_replace(' |', '|', $output_lines);
        $output_lines = str_replace('| ', '|', $output_lines);
        $lines = explode("\n", $output_lines);

        $num_of_rows = count($lines)-4-6; // 4 lines are header and 6 lines are footer
        $lines = array_slice($lines, 4, $num_of_rows); // get only body without header and footer

        // create array from ascii table
        $table_rows = [];
        foreach ($lines as $line) {
            array_push($table_rows, array_combine($table_header_keys, explode("|", $line)));
        }

        $command_output = $output_lines;

        return view('deployments.check', [
            'table_rows' => $table_rows,
            'output' => $command_output,
            'result_code' => $result_code,
            'alert' => 'alert-danger'
        ]);
    }


    /**
     * Delete deployment from system
     */
    public function delete($uuid)
    {
        $this->authorize('delete-deployment');

        $command = 'nixops delete -d ' . $uuid . ' -I /nix/var/nix/profiles/per-user/root/channels/nixos/ 2>&1';

        $output_lines = null;
        $result_code = null;
        $returnVal = exec($command, $output_lines, $result_code);

        if($result_code != 0) {
            $message = "An error occured while deleting deployment:";
            $command_output = implode("\n", $output_lines);
            return redirect()->to('/deployments')->with([
                'alert' => 'alert-danger',
                'message' => $message,
                'output' => $command_output
            ]);
        }
        else if ($result_code == 0) {
            $message = "Deleting of deployment successfully finished. ";
            $command_output = implode("\n", $output_lines);
            return redirect()->to('/deployments')->with([
                'alert' => 'alert-success',
                'message' => $message,
            ]);
        }
    }

    /**
     * Destroy deployment
     */
    public function destroy($uuid)
    {
        $this->authorize('destroy-deployment');

        $command = 'nixops destroy -d ' . $uuid . ' -I /nix/var/nix/profiles/per-user/root/channels/nixos/ 2>&1';

        $output_lines = null;
        $result_code = null;
        $returnVal = exec($command, $output_lines, $result_code);

        if($result_code == 0) {
            $message = "An error occured while destroying deployment:";
            $command_output = implode("\n", $output_lines);
            return redirect()->to('/deployments')->with([
                'alert' => 'alert-danger',
                'message' => $message,
                'output' => $command_output
            ]);
        }
        else if ($result_code != 0) {
            $message = "Destroying of deployment successfully finished. ";
            $command_output = implode("\n", $output_lines);
            return redirect()->to('/deployments')->with([
                'alert' => 'alert-success',
                'message' => $message,
                // 'output' => $command_output
            ]);
        }
    }
}
