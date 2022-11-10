<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;

class IndexController extends Controller
{
    public function index()
    {
//        $posts = Post::all()->sortByDesc(function($post) {
//            return $post->ratings->avg('rating');
//        })->take(100);

        $posts = Post::query()
            ->select('title', 'created_at')
            ->addSelect([
                'category_title' => Category::query()
                    ->select('title')
                    ->whereColumn('category_id','categories.id')
            ])
            ->withAvg('ratings','rating')
            ->withCount('ratings')
            ->orderByDesc('ratings_avg_rating')
            ->take(100)
            ->get();

        return view('welcome', [
            'posts' => $posts
        ]);
    }
}
