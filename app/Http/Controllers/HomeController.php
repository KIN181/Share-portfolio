<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    private $post;
    private $user;

    public function __construct(Post $post, User $user)
    {
        $this->post = $post;
        $this->user = $user;
    }


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    # Get the posts of the users that the Auth user is following
    private function getHomePosts()
    {
        $all_posts  = $this->post->latest()->get();
        $home_posts = []; // In case the $home_posts is empty, it wil not return NULL, but empty instead

        foreach ($all_posts as $post){
            if ($post->user->isfollowed() || $post->user->id === Auth::user()->id){
                $home_posts[] = $post;
                /*
                    $home_posts = [
                        'Test post by EA',
                        'asdf asdf asdf',
                        'TEst hahah hehehe hoohoho'
                    ];
                */ 
            }
        }

        return $home_posts;
    }



    public function index()
    {
        $home_posts      = $this->getHomePosts();
        $suggested_users = $this->getSuggestedUsers();

        return view('users.home')
                ->with('home_posts', $home_posts)
                ->with('suggested_users', $suggested_users);
    }


    # Get the users that Auth user is not following
    private function getSuggestedUsers()
    {
        $all_users = $this->user->all()->except(Auth::user()->id);
        $suggested_users = [];

        foreach ($all_users as $user){
            if (!$user->isFollowed()){
                $suggested_users[] = $user;
                /*
                    $suggested_users = [
                        ['id' => 2, 'name' => 'EA'],
                        ['id' => 3, 'name' => 'Ehyley'],
                    ];
                */ 
            }
        }

        return array_slice($suggested_users, 0, 5);
        // array_slice - PHP built-in function that extracts slice of an array
        // array_slice(array_name, starting index, no. of items)
    }



    public function suggestions()
    {
        $all_users = $this->user->all()->except(Auth::user()->id);
        $suggested_users = [];

        foreach ($all_users as $user){
            if (!$user->isFollowed()){
                $suggested_users[] = $user;
                /*
                    $suggested_users = [
                        ['id' => 2, 'name' => 'EA'],
                        ['id' => 3, 'name' => 'Ehyley'],
                    ];
                */ 
            }
        }

        return view('users.suggestions')
                ->with('suggested_users', $suggested_users);
    }

    public function search(Request $request)
    {
        $users = $this->user->where('name','like','%' .$request->search .'%')->get();
        return view('users.search')
             ->with('users',$users)
             ->with('search',$request->search);
    }



}
