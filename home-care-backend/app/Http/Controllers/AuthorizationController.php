<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthorizationController extends Controller
{
    public function setup()
    {
        // User::find(17)->assignRole('admin', 'super-admin');
        $roles = ['client', 'home-care-worker'];
        foreach ($roles as $p) {
            try {
                Role::create([
                    'name' => $p
                ]);
            } catch (\Throwable $th) {
                continue;
            }
        }

        $permissions = [

        ];

        foreach ($permissions as $p) {
            try {
                Permission::create([
                    'name' => $p
                ]);
            } catch (\Throwable $th) {
                continue;
            }
        }
        //i commented the view-naira-wallet for users.
        $client_permissions = [];
        $client = Role::where('name', 'client')->first();
        foreach ($client_permissions as $c) {
            try {
                $client->givePermissionTo($c);
            } catch (\Throwable $th) {
                continue;
            }
        }

        $home_care_permissions = [

        ];
        $homeCare = Role::where('name', 'home-care-worker')->first();
        foreach ($home_care_permissions as $hcp) {
            try {
                $homeCare->givePermissionTo($hcp);
            } catch (\Throwable $th) {
                continue;
            }
        }


    }
}
