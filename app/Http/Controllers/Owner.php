<?php

namespace App\Http\Controllers;



use App\Clients;
use App\CreateDevice;
use App\User;
use Illuminate\Http\Request;

class Owner extends Controller
{

    /**
     * CreateClient - function for creating clients
     * param - request - takes all the post request data
    */
    public function createClient(Request $request){
        if($request->isMethod('post')){
            $errors = array();
            if($request->password != $request->repass){
                $errors[] = 'Password didn\'t match.';
            }

            $user = new User();
            $client = new Clients();

            if(!$user->validate($request->all())){
                $user_e = $user->errors();
                foreach ($user_e->messages() as $k => $v){
                    foreach ($v as $e){
                        $errors[] = $e;
                    }
                }
            }

            if(!$client->validate($request->all())){
                $client_e = $client->errors();
                foreach ($client_e->messages() as $k => $v){
                    foreach ($v as $e){
                        $errors[] = $e;
                    }
                }
            }

            if(empty($errors)){
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = bcrypt($request->password);
                $user->role = 'client';
                $user->status = 'dev';
                $user->save();

                if($user->save()){
                    $client->user_id = $user->id;
                    $client->client_id = $request->client_id;
                    $client->client_type = $request->client_type;
                    $client->phone = $request->phone;
                    if($request->hasFile('file')) {
                        $image = $request->file('file');
                        $name = str_slug($user->id).'.'.$image->getClientOriginalExtension();
                        $destinationPath = public_path('/uploads/clients/payment_files');
                        $image->move($destinationPath, $name);
                        $client->payment_file = $name;
                    }
                    if($client->save()){
                        return redirect()
                            ->to('/create-client')
                            ->with('success', 'The client was created successfully!!');
                    }else{
                        User::destroy($user->id);
                        return redirect()
                            ->to('/create-client')
                            ->with('error', 'Something went wrong! Please try again!');
                    }
                }else{
                    return redirect()
                        ->to('/create-client')
                        ->with('error', 'Something went wrong! Please try again!');
                }
            }else{
                return redirect()
                    ->to('/create-client')
                    ->with('errors', $errors)
                    ->withInput();
            }
        }
        return view('pages.owner.create-client');
    }

    /**
     * all clients - function to show all clients
     **/
    public function allClients(Request $request){
        $clients = Clients::all();
        foreach($clients as $client){
            $client->data = User::find($client->user_id);
        }

        if($request->isMethod('post')){
            $stat = User::find($request->client_id);
            $stat->status = $request->status;
            if($stat->save()){
                return redirect()
                    ->to('/clients-list')
                    ->with('success', 'The client was '.$request->status.'ed successfully!');
            }else{
                return redirect()
                    ->to('/clients-list')
                    ->with('error', 'Something went wrong! Please try again!');
            }
        }

        return view('pages.owner.clients-list', [
            'clients' => $clients
        ]);
    }

    /**
     * client details - function to show details of a client
     */
    public function clientDetails(Request $request){
        if(!isset($request->client_id)){
            abort(404);
        }

        $client = Clients::where('client_id', $request->client_id)->first();
        $client->data = User::find($client->user_id);

        if($request->isMethod('post')){
            if($request->action == 'pass'){
                $pass_e = array();
                if($request->password != $request->repass){
                    $pass_e[] = 'Password didn\'t match.';
                }
                if(empty($pass_e)){
                    $edit_pass = User::find($client->user_id);
                    $edit_pass->password = bcrypt($request->password);
                    if($edit_pass->save()){
                        return redirect()
                            ->to('/client-details?client_id='.$client->client_id)
                            ->with('success', 'Password was reset successfully!');
                    }else{
                        return redirect()
                            ->to('/client-details?client_id='.$client->client_id)
                            ->with('error', 'Something went wrong! Please try again!');
                    }
                }
                else{
                    return redirect()
                        ->to('/client-details?client_id='.$client->client_id)
                        ->with('errors', $pass_e);
                }
            }
            if($request->action == 'edit-data'){
                $client = Clients::where('client_id', $request->client_id)->first();
                $client->phone = $request->phone;
                if($request->hasFile('file')) {
                    $image = $request->file('file');
                    $name = str_slug($client->user_id).'.'.$image->getClientOriginalExtension();
                    $destinationPath = public_path('/uploads/clients/payment_files');
                    $image->move($destinationPath, $name);
                    $client->payment_file = $name;
                }
                if($client->save()){
                    return redirect()
                        ->to('/client-details?client_id='.$client->client_id)
                        ->with('success', 'Info was edited successfully!');
                }else{
                    return redirect()
                        ->to('/client-details?client_id='.$client->client_id)
                        ->with('error', 'Something went wrong! Please try again!');
                }
            }
        }

        return view('pages.owner.client-details', [
            'client' => $client,
            'js' => 'pages.owner.js.client-details-js',
            'modal' => 'pages.owner.modals.client-details-modal'
        ]);
    }

    /**
     * CreateDevice - function for creating devices
     * param - request - takes all the post request data
     */
    public function createDevice(Request $request){
        if($request->isMethod('post')){
            $errors = array();
            $cd = new CreateDevice();
            if(!$cd->validate($data)){
                $cd_e = $cd->errors();
                foreach ($cd_e->messages() as $k => $v){
                    foreach ($v as $e){
                        $errors[] = $e;
                    }
                }
            }

            if(empty($errors)){
                $cd->device_id = $request->device_id;
                $cd->factory_id = $request->factory_id;
                $cd->charger_id = $request->charger_id;
                $cd->created_by = 'PIC';
                $cd->modified_by = 'MOD';
                $cd->status = 'unassigned';
                if($cd->save()){
                    return redirect()
                        ->to('/create-device')
                        ->with('success', 'The device was created successfully!!');
                }else{
                    return redirect()
                        ->to('/create-device')
                        ->with('error', 'Something went wrong! Please try again!');
                }
            }else{
                return redirect()
                    ->to('/create-client')
                    ->with('errors', $errors)
                    ->withInput();
            }
        }
        return view('pages.owner.create-device');
    }


    /**
     * ManageDevice - function for managing devices
     * param - request - takes all the post request data
     */
    public function manageDevice(){
        return view('pages.owner.manage-device');
    }


}
