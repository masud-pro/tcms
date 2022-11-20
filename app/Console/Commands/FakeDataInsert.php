<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Course;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;

class FakeDataInsert extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fake:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fake data insert into database by faker';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        $dataInsert = $this->ask( 'Do you want to insert data into the database[Yes|No]?' );

        if ( $dataInsert == "yes" ) {
            $this->info( 'Hello console...!' );
            Artisan::call( 'migrate:fresh' );
            Artisan::call( 'db:seed' );

            User::insert( [
                'name'              => 'Masud Rana',
                'email'             => '920mash@gmail.com',
                'phone_no'          => '01743203347',
                'email_verified_at' => now(),
                'password'          => Hash::make( '&#Mb619)hub' ),
                'role'              => 'Admin',
            ] );

            // Artisan::call( 'db:seed --class=AdministratorSeeder' );
            
            $courseNumber = $this->ask( 'How many Course do need ..?' );
            
            for ( $i = 0; $i < $courseNumber; $i++ ) {
                Course::factory( 1 )->create();
            }
            
            $userNumber = $this->ask( 'How many User do need ..?' );
            
            for ( $i = 0; $i < $userNumber; $i++ ) {
                $user = User::factory( 1 )->create();
                $user[0]->assignRole( 'Student' );
            }
            
            Artisan::call( 'db:seed --class=CourseUserSeeder' );
            $this->comment( 'Fake data insert into the database Successfully ...' );
        } else {
            $this->error( 'Oops yous successfully ...' );
        }

    }
}
