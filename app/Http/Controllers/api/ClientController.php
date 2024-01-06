<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\User;


class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::orderBy('created_at', 'desc')->get();

        return response()->json($clients, 200);
    }

    public function view($id)
    {
        $client = Client::where('id', $id)->first();

        if($client)
        {
            return response()->json($client, 200);
        }

        return response()->json(['error' => 'Client not found'], 404);
    }

    //filter client base on first_name, last_name, email, telephone
    public function filter(Request $request)
    {
        \Log::info('Inside the filter');

        \Log::info(json_encode('Filter Request: '  . $request));

        $clients = Client::where('first_name', 'like', '%'.$request->search.'%')
            ->orWhere('last_name', 'like', '%'.$request->search.'%')
            ->orWhere('email_address', 'like', '%'.$request->search.'%')
            ->orWhere('telephone', 'like', '%'.$request->search.'%')
            ->orderBy('created_at', 'desc')
            ->get();

            \Log::info(json_encode('GOt Filter Request: '  . $clients));

        return response()->json($clients, 200);
    }

    public function save(Request $request)
    {
        try
        {
            $request->validate([
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'id_number' => 'required|string|unique:clients,id_number',
                'dob' => 'required|date',
                'telephone' => 'required|string|unique:clients,telephone',
                'email_address' => 'required|string|email|unique:clients,email_address',
            ],
            [
                'first_name.required' => 'First name is required',
                'last_name.required' => 'Last name is required',
                'id_number.required' => '13 digit ID number is required',
                'dob.required' => 'Date of birth is required',
                'telephone.required' => 'Telephone is required',
                'email_address.required' => 'Email address is required',
                'email_address.email' => 'Please provide valid Email address',
                'telephone.unique' => 'User with this telephone number already exists',
                'email_address.unique' => 'User with this email address already exists',
                'id_number.unique' => 'User with this id number already exists',
            ]);
    
            $client = Client::create([
                'uuid' => \Str::uuid(),
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'id_number' => $request->id_number,
                'dob' => $request->dob,
                'telephone' => $request->telephone,
                'email_address' => $request->email_address,
            ]);

            return response()->json(['message' => 'Client added successfully', 'client' => $client], 201);
        }
        catch(\Illuminate\Validation\ValidationException $e)
        {
            return response()->json(['errors' => $e->errors()], 422);
        }
        
    }

    public function update(Request $request, $id)
    {
        try
        {
            $request->validate([
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'id_number' => 'required|string',
                'dob' => 'required|date',
                'telephone' => 'required|string',
                'email_address' => 'required|string|email',
            ],
            [
                'first_name.required' => 'First name is required',
                'last_name.required' => 'Last name is required',
                'id_number.required' => '13 digit ID number is required',
                'dob.required' => 'Date of birth is required',
                'telephone.required' => 'Telephone is required',
                'email_address.required' => 'Email address is required',
                'email_address.email' => 'Please provide valid Email address',
            ]);
    
            $client = Client::where('id', $id)->first();

            if(!empty($client))
            {
                $client->update([
                    'first_name' => $request->first_name,
                    'last_name' => $request->last_name,
                    'id_number' => $request->id_number,
                    'dob' => $request->dob,
                    'telephone' => $request->telephone,
                    'email_address' => $request->email_address,
                    'status' => $request->has('status') ? $request->status : 1,
                ]);

                return response()->json(['message' => 'Client updated successfully', 'client' => $client], 200);
            }

            return response()->json(['error' => 'Client not found'], 404);
        }
        catch(\Illuminate\Validation\ValidationException $e)
        {
            return response()->json(['errors' => $e->errors()], 422);
        }
        
    }

    public function delete($id)
    {
        $client = Client::where('id', $id)->first();

        if($client)
        {
            $client->delete();

            return response()->json(['message' => 'Client deleted successfully'], 200);
        }

        return response()->json(['error' => 'Client not found'], 404);
    }

}
