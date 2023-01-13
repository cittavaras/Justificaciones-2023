<?php

namespace App\Console\Commands;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Console\Command;
use Log;
use App\User;

class mysql extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mysql:cifrar {argumento$}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        Log::debug('ejecutar migracion de datos');
        // DB::statement('UPDATE elements e
        //        JOIN drafts d
        //        SET e.data = d.data WHERE e.id = d.element_id');

        // DB::statement('UPDATE users u
        // SET u.password = Hash::make('1234')');

        $users = User::get(); // fetches all user data in users table.
        foreach($users as $user) {
            // Log::debug($user->password);
            $cifrar = Hash::make($user->password);
            // Log::debug($cifrar);
            // $tmpEmail = $user->email;
            $user->password = $cifrar;
            $user->save();
            // DB::statement('UPDATE users u
            // SET u.password = "$cifrar" WHERE u.email = "$tmpEmail"');
            // if(Hash::check($user->device_token, $request->device_token)) {
            //     // user is authenticated
            // };
        }
        // DB::table('users as u')
        // ->update([ 'u.password' => Hash::make('u.password')]);
        // ->update([ 'u.password' => Hash::make(DB::raw('u.password'))]);
        // ->update([Hash::make('u.password') => DB::raw('u.password')]);

        // DB::table('elements as e')
        // ->join('element_drafts as d', 'd.element_id', '=', 'e.id')
        // ->update(['e.data' => DB::raw('d.data')]);

        // $password = Hash::make('holamundo');
        // Log::debug($password);
        // Log::debug($this->argument('argumento'));
    }
}
