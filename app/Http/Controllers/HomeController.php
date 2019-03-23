<?php

namespace App\Http\Controllers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Show the application welcome page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function welcome()
    {
        return view('welcome');
    }
	
	public function runArtisan()
	{
		if(auth()->user()->email == 'manichevassvetlana@gmail.com') {
            Schema::create('chatter_categories', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('parent_id')->unsigned()->nullable();
                $table->integer('order')->default(1);
                $table->string('name');
                $table->string('color', 20);
                $table->string('slug');
                $table->timestamps();
            });

            Schema::create('chatter_discussion', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('chatter_category_id')->unsigned()->default('1');
                $table->string('title');
                $table->integer('user_id')->unsigned();
                $table->boolean('sticky')->default(false);
                $table->integer('views')->unsigned()->default('0');
                $table->boolean('answered')->default(0);
                $table->timestamps();
            });

            Schema::create('chatter_post', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('chatter_discussion_id')->unsigned();
                $table->integer('user_id')->unsigned();
                $table->text('body');
                $table->timestamps();
            });

            Schema::table('chatter_discussion', function (Blueprint $table) {
                $table->foreign('chatter_category_id')->references('id')->on('chatter_categories')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
                $table->foreign('user_id')->references('id')->on('users')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            });
            Schema::table('chatter_post', function (Blueprint $table) {
                $table->foreign('chatter_discussion_id')->references('id')->on('chatter_discussion')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
                $table->foreign('user_id')->references('id')->on('users')
                    ->onDelete('cascade')
                    ->onUpdate('cascade');
            });

            Schema::table('chatter_discussion', function (Blueprint $table) {
                $table->string('slug')->unique();
            });

            Schema::table('chatter_discussion', function (Blueprint $table) {
                $table->string('color', 20)->nullable()->default('#232629');
            });

            Schema::table('chatter_post', function (Blueprint $table) {
                $table->boolean('markdown')->default(0);
                $table->boolean('locked')->default(0);
            });

            Schema::create('chatter_user_discussion', function (Blueprint $table) {
                $table->integer('user_id')->unsigned()->index();
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->integer('discussion_id')->unsigned()->index();
                $table->foreign('discussion_id')->references('id')->on('chatter_discussion')->onDelete('cascade');
                $table->primary(['user_id', 'discussion_id']);
            });

            Schema::table('chatter_discussion', function (Blueprint $table) {
                $table->softDeletes();
            });
            Schema::table('chatter_post', function (Blueprint $table) {
                $table->softDeletes();
            });

            Schema::table('chatter_discussion', function (Blueprint $table) {
                $table->timestamp('last_reply_at')->useCurrent();
            });



            DB::table('chatter_categories')->insert([
                0 => [
                    'id'         => 2,
                    'parent_id'  => null,
                    'order'      => 2,
                    'name'       => 'General',
                    'color'      => '#2ECC71',
                    'slug'       => 'general',
                    'created_at' => null,
                    'updated_at' => null,
                ],
            ]);
        }
	}
		
	
}
